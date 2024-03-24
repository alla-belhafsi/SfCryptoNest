<?php

namespace App\Controller;

use App\Entity\Feedback;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'app_feedback')]
    public function index(): Response
    {
        return $this->render('feedback/index.html.twig', [
            'controller_name' => 'FeedbackController',
        ]);
    }

    # Définir une nouvelle route pour récupérer le commentaire complet
    // #[Route('/feedback/{id}', name: 'get_feedback')]
    // public function getFeedbackAction($id, EntityManagerInterface $entityManager)
    // {
    //     // Récupérer le commentaire complet depuis la base de données en fonction de son identifiant
    //     $feedback = $entityManager->getRepository(Feedback::class)->find($id);

    //     // Vérifier si le commentaire a été trouvé
    //     if (!$feedback) {
    //         return new JsonResponse(['error' => 'Comment not found'], 404);
    //     }

    //     // Retourner le commentaire complet au format JSON
    //     return new JsonResponse(['comment' => $feedback->getComment()]);
    // }

    # Définir une nouvelle route pour supprimer une feedback
    #[Route('/feedback/{id}/delete', name: 'delete_feedback')]
    public function delete (Feedback $feedback, EntityManagerInterface $entityManager, Request $request): Response
    {
        // Récupérer l'URL de la page actuelle
        $referer = $request->headers->get('referer');
    
        // Préparer l'entité à être supprimée de la base de données
        $entityManager->remove($feedback);
    
        // Exécuter la suppression des données en base de données
        $entityManager->flush();
    
        // Rediriger vers l'URL de la page précédente après la suppression réussie
        return $this->redirect($referer);
    }

}
