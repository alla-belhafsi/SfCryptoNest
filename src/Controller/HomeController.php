<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\UserRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(UserRepository $userRepository, PropertyRepository $propertyRepository): Response
    {
        $users = $userRepository->findBy([], ["roles" => "DESC"]);
        $properties = $propertyRepository->findBy([], ["title" => "ASC"]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties,
            'users' => $users,
        ]);
    }

    public function searchByCity(EntityManagerInterface $entityManager, Request $request): Response
    {
        $city = $request->query->get('city');

        // Convertir la ville en minuscules pour rendre la recherche insensible à la casse
        $city = strtolower($city);

        $properties = $entityManager->getRepository(Property::class)
            ->createQueryBuilder('p')
            ->where('LOWER(p.city) = :city')
            ->setParameter('city', $city)
            ->getQuery()
            ->getResult();

        return $this->render('home/index.html.twig', [
            'properties' => $properties,
            'city' => $city,
        ]);
    }
}
