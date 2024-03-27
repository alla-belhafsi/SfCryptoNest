<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Feedback;
use App\Entity\Property;
use App\Form\BookingType;
use App\Form\FeedbackType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(BookingRepository $bookingRepository): Response
    {
        $bookings = $bookingRepository->findBy([], ["startDate" => "ASC"]);
        
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    # Définir une nouvelle route pour créer une nouvelle Réservation
    #[Route('/booking/new/{propertyId}', name: 'new_booking')]
    # Définir une nouvelle route pour éditer une Booking
    #[Route('/booking/{id}/edit', name: 'edit_booking')]
    public function new_edit($propertyId, Booking $booking = null, BookingRepository $bookingRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Si booking n'existe pas, créer une nouvelle instance de l'entité booking 
        if (!$booking) {
            $booking = new Booking();
        
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            // Récupérer l'id de la propriété
            $property = $entityManager->getRepository(Property::class)->find($propertyId);

            // Prédéfinir Booking.user.id en tant que app.user.id
            $booking->setUser($user);

            // Prédéfinir Booking.property avec la propriété correspondante
            $booking->setProperty($property);

            // Prédéfinir booking.bookingDate avec la date et l'heure d'aujourd'hui en France
            $booking->setBookingDate(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));
        
            // Créer un formulaire basé sur le type de formulaire BookingType et l'entité Booking
            $form = $this->createForm(BookingType::class, $booking, [
                'user' => $user,
            ]);
        } else {
            // Si booking existe, assurez-vous que le formulaire est créé correctement
            $form = $this->createForm(BookingType::class, $booking);
        }

        // Traiter la requête HTTP pour remplir le formulaire
        $form->handleRequest($request);

        $bookedDatesArray = [];

        // Récupérer toutes les réservations existantes
        $bookedDates = $bookingRepository->findBy(['property' => $property]);
        
        foreach ($bookedDates as $booking) {
            $bookedDatesArray[] = [
                'title' => 'Reserved',
                'start' => $booking->getStartDate()->format('Y-m-d'),
                'end' => $booking->getEndDate()->format('Y-m-d'),
                'duration' => $booking->getDuration(),
            ];
        }
        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Récupérer les données soumises dans le formulaire ($form->getData() contient les valeurs soumises dans le formulaire)
            $booking = $form->getData();

            // Si les dates ne sont pas dispo, message d'erreur
            if (!$booking->isBookableDates()) {
                // Passer les erreurs au template Twig
                $this->addFlash('error', 'The selected dates are not available.');
            } else {
                // Le montant doit être défini avant la persistance
                $amount = $property->getPrice() * $booking->getDuration(); 
                $booking->setAmount($amount);
                // Préparer l'entité à être persistée (ajoutée) en base de données (Prepare PDO)
                $entityManager->persist($booking);
                // Exécuter la persistance des données en base de données (Execute PDO)
                $entityManager->flush();
                // Get the ID of the newly created booking
                $bookingId = $booking->getId();
                // Redirirger l'utilisateur vers la Confirmation de sa réservation
                $this->addFlash('success', 'Congratulations! Your reservation has been successfully processed!');

                // Rediriger vers le panneau de configuration après l'ajout réussi
                return $this->redirectToRoute('show_booking', ['id' => $bookingId]);
            }
        }
        
        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('booking/new.html.twig', [
            'formAddBooking' => $form,
            'edit' => $booking->getId(),
            'booking' => $booking,
            'propertyPrice' => $property->getPrice(),
            'bookedDates' => json_encode($bookedDatesArray),
        ]);
    }

    # Définir une nouvelle route pour supprimer une booking
    #[Route('/booking/{id}/delete', name: 'delete_booking')]
    public function delete (Booking $booking, EntityManagerInterface $entityManager): Response
    {
        // Préparer l'entité à être supprimer de la base de données (Prepare PDO)
        $entityManager->remove($booking);

        // Exécuter la suppression des données en base de données (Execute PDO)
        $entityManager->flush();

        // addFlash() sert à notifier l'utilisateur de ce qui a été fait (param 1 = type de message, param 2 = message)
        $this->addFlash(
            'success',
            "Your Reservation has been successfully deleted !"
        );

        // Rediriger vers la liste des bookings après la suppression réussi
        return $this->redirectToRoute('app_booking');
    }

    # Définir une nouvelle route pour voir le détail d'une réservation
    #[Route('/booking/{id}', name: 'show_booking')]
    public function show(Booking $booking, Request $request, EntityManagerInterface $entityManager): Response
    {
        
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        // Récupérer l'annonce de la réservation actuelle
        $property = $booking->getProperty();

        $feedback = new Feedback();

        // Prédéfinir Feedback.user.id en tant que app.user.id
        $feedback->setUser($user);
        // Prédéfinir Feedback.user.id en tant que booking.property.id
        $feedback->setProperty($property);

        // Prédéfinir feedback.createdAt avec la date et l'heure d'aujourd'hui en France
        $feedback->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris')));

        $form = $this->createForm(FeedbackType::class, $feedback);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ajouter la réservation actuelle à la rétroaction
            // $feedback->setBooking($booking);

            $entityManager->persist($feedback);
            $entityManager->flush();

            // addFlash() sert à notifier l'utilisateur de ce qui a été fait (param 1 = type de message, param 2 = message)
            $this->addFlash(
                'success',
                "Your feedback has been successfully received !"
            );
        }

        return $this->render('booking/showBooking.html.twig', [
            'booking' => $booking,
            'formAddFeedback' => $form->createView()
        ]);
    }

}
