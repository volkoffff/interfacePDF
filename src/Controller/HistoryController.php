<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HistoryController extends AbstractController
{
    #[Route('/history', name: 'app_history')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // récupérer les PDFs générés par l'utilisateur connecté
        $pdfs = $user->getPdfs();


        return $this->render('history/index.html.twig', [
            'controller_name' => 'HistoryController',
            'user' => $user,
            'pdfs' => $pdfs,
        ]);
    }
}
