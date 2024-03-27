<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $bookingDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?user $user = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?property $property = null;

    public function isPast(): bool
    {
        return $this->endDate < new \DateTime();
    }

    public function isCurrent(): bool
    {
        return $this->endDate >= new \DateTime() && $this->startDate <= new \DateTime();
    }

    public function isUpcoming(): bool
    {
        return $this->startDate > new \DateTime();
    }

    public function isBookedDates(): bool
    {
        $existingBookings = $this->bookingRepository->findByPropertyAndDates(
            $this->getProperty(),
            $this->getStartDate(),
            $this->getEndDate()
        );

        if (!empty($existingBookings)) {
            // S'il existe déjà des réservations pour les mêmes dates et la même propriété
            return false;
        }

        // Sinon, les dates sont disponibles
        return true;
    }

    // Permet de retourner true si les dates sont toujours disponibles
    public function isBookableDates(){
        // 1) On récupère l'ensemble des journées pour lesquels cette annonce n'est pas disponible 
        $notAvailableDays = $this->getProperty()->getNotAvailableDays();

        // 2) On récupère l'ensemble des journées de ma réservation en cours 
        $bookingDays = $this->getDays();

        // Fonction qui sera l'argument1 de la fonction array_map() plus bas
        $formatDay = function($day){  
            return $day->format('Y-m-d');
        };

        // On transforme le tableau "bookingDays" (tableau de type DateTime) en chaine de caractères de type Y-m-d soit un format date
        $days = array_map($formatDay, $bookingDays);

        // On transforme le tableau "notAvailableDays" (tableau de type DateTime) en chaine de caractères de type Y-m-d soit un format date
        $notAvailableDays = array_map($formatDay, $notAvailableDays); 

        // On boucle sur les jours de la réservation ($days), et pour chaque journée on regarde si elle est présente parmi les journées non disponibles,
        // si c'est le cas, alors cela retourne false, sinon retourne true
        foreach($days as $day){
            if(array_search($day, $notAvailableDays) !== false || strtotime($day) < strtotime(date("Y-m-d"))) return false;
        }

        return true;
    }
    

    // Permet de récupérer un tableau des journées $days qui correspondent à ma réservation
    public function getDays()
    {
        $resultat = range(
            $this->startDate->getTimestamp(),
            $this->endDate->getTimestamp(),
            24 * 60 * 60
        );

        $days = array_map(function($dayTimestamp){
            return new \DateTime(date('Y-m-d', $dayTimestamp));
        }, $resultat);

        return $days; 
    }
    
    // Fonction manuelle qui calcul la duréé d'un annonce (soit la différence entre la date de début (startDate) et la date de fin (endDate)
    public function getDuration()
    {
        // La méthode diff() provient des objet de type DateTime et permet de faire la différence entre 2 dates et renvoie un objet DateInterval
        $diff = $this->endDate->diff($this->startDate);
        return $diff->days; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookingDate(): ?\DateTimeInterface
    {
        return $this->bookingDate;
    }

    public function setBookingDate(\DateTimeInterface $bookingDate): static
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getProperty(): ?property
    {
        return $this->property;
    }

    public function setProperty(?property $property): static
    {
        $this->property = $property;

        return $this;
    }

}
