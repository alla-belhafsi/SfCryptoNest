<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepository, PropertyRepository $propertyRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $property = $propertyRepository->findBy([], ["title" => "ASC"]);

        $pagination = $paginator->paginate(
            $userRepository->paginationQuery(),
            $request->query->get('page', 1),
            10
        );

        return $this->render('user/index.html.twig', [
            'property' => $property,
            'pagination' => $pagination
        ]);
    }

    # Définir une nouvelle route pour éditer un utilisateur
    #[Route('/user/{id}/edit', name: 'edit_user')]
    public function edit(User $user = null, Request $request, EntityManagerInterface $entityManager): Response
    {   
        // Créer un formulaire basé sur le type de formulaire RegisterType et l'entité stagiaire
        $form = $this->createForm(UserType::class, $user);

        // Traiter la requête HTTP pour remplir le formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les données soumises dans le formulaire ($form->getData() contient les valeurs soumises dans le formulaire)
            $user = $form->getData();

            // Préparer l'entité à être persistée (ajoutée) en base de données (Prepare PDO)
            $entityManager->persist($user);

            // Exécuter la persistance des données en base de données (Execute PDO)
            $entityManager->flush();

            // Rediriger vers la liste des users après la modification réussi
            return $this->redirectToRoute('show_user', [
                'id' => $user->getId()
            ]);
        }
        
        // Si le formulaire n'a pas été soumis ou n'est pas valide, afficher le formulaire
        return $this->render('user/edit.html.twig', [
            'formModifyUser' => $form,
            'edit' => $user->getId(),
            'user' => $user
        ]);
    }

    # Définir une nouvelle route pour supprimer un user
    #[Route('/user/{id}/delete', name: 'delete_user')]
    public function delete (User $user, EntityManagerInterface $entityManager): Response
    {
        // Préparer l'entité à être supprimer de la base de données (Prepare PDO)
        $entityManager->remove($user);

        // Exécuter la suppression des données en base de données (Execute PDO)
        $entityManager->flush();

        // Rediriger vers la liste des users après la suppression réussi
        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/{id}', name: 'show_user')]
    public function show(UserRepository $userRepository, PropertyRepository $propertyRepository): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Tri des properties par pays (ASC)
        $properties = $propertyRepository->findBy(['user' => $user], ["country" => "ASC"]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'properties' => $properties,
        ]);
    }
}
