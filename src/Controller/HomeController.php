<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PropertyRepository;
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
}
