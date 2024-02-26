<?php

namespace App\Controller;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    #[Route('/property', name: 'app_property')]
    public function index(PropertyRepository $propertyRepository): Response
    {
        $properties = $propertyRepository->findBy([], ["title" => "ASC"]);
        return $this->render('property/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    # Définir une nouvelle route pour créer une nouvelle Property
    #[Route('/property/new', name: 'new_property')]
    # Définir une nouvelle route pour éditer une Property
    #[Route('/property/{id}/edit', name: 'edit_property')]
    public function new_edit(Property $property = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Si la property n'existe pas, créer une nouvelle instance de l'entité property 
        if(!$property) 
        {
            $property = new Property();
        }
        
        // Créer un formulaire basé sur le type de formulaire PropertyType et l'entité Property
        $form = $this->createForm(PropertyType::class, $property);

        // Traiter la requête HTTP pour remplir le formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données soumises dans le formulaire ($form->getData() contient les valeurs soumises dans le formulaire)
            $property = $form->getData();

            // Préparer l'entité à être persistée (ajoutée) en base de données (Prepare PDO)
            $entityManager->persist($property);

            // Exécuter la persistance des données en base de données (Execute PDO)
            $entityManager->flush();

            // Rediriger vers le panneau de configuration après l'ajout réussi
            return $this->redirectToRoute('app_home', []);
           }
        
        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('property/new.html.twig', [
            'formAddProperty' => $form,
            'edit' => $property->getId(),
            'property' => $property
        ]);
    }

    # Définir une nouvelle route pour supprimer une property
    #[Route('/property/{id}/delete', name: 'delete_property')]
    public function delete (Property $property, EntityManagerInterface $entityManager): Response
    {
        // Préparer l'entité à être supprimer de la base de données (Prepare PDO)
        $entityManager->remove($property);

        // Exécuter la suppression des données en base de données (Execute PDO)
        $entityManager->flush();

        // Rediriger vers la liste des properties après la suppression réussi
        return $this->redirectToRoute('app_property');
    }

    #[Route('/property/{id}', name: 'show_module')]
    public function show (Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }
}
