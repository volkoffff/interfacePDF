<?php
// src/Controller/GeneratePdfController.php

namespace App\Controller;

use App\Entity\Pdf;
use App\Form\Type\pdf_form;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;

class GeneratePdfController extends AbstractController
    {
    #[Route('/generate_pdf', name: 'form_pdf', methods: ['POST', 'GET'])]
    public function generatePdf(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer le formulaire
        $form = $this->createForm(pdf_form::class);

        // Gérer la soumission du formulaire
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérer l'URL et le title saisie à partir des données du formulaire
            $url = $form->getData()['url'];
            $title = $form->getData()['title'];

            // vérifier si l'URL contient "https://"
            if (!str_contains($url, 'https://')) {
                $url = 'https://' . $url;
            };

            $client = httpClient::create();

            $response = $client->request(
                'POST',
                'http://127.0.0.1:8000/gotenberg/convert',
                [
                    'headers' => [
                        'Content-Type' => 'multipart/form-data',
                    ],
                    'body' => [
                        'url' => $url,
                    ]
                ]
            );

            // vérifier si il y à une erreur
            if ($response->getStatusCode() !== 200) {
                // Gérer l'erreur ici
                throw new \Exception('Failed to generate PDF from URL.');
            }

            // remove 1 token from the user
            $user = $this->getUser();
            $user -> setTokens($user->getTokens() - 1);

            // Récupérer le contenu du PDF généré
            $pdfContent = $response->getContent();

            // Enregistrer le PDF dans le dossier "upload"
            $fileName = 'generated_pdf_' . uniqid() . '.pdf'; // Nom du fichier généré
            $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads'; // Chemin vers le dossier "upload"
            $filePath = $uploadDirectory . '/' . $fileName;

            // Écrire le contenu du PDF dans un fichier
            file_put_contents($filePath, $pdfContent);

            $pdf = new Pdf();
            $pdf -> setTitle($title);
            $pdf -> setCreatedAt(new \DateTimeImmutable());
            $pdf -> setFilePath('uploads/' . $fileName);
            $pdf -> setOwner($this->getUser());
            $entityManager->persist($pdf);
            $entityManager->flush();

            // Récupérer le chemin et le nom du fichier PDF généré
            $pdfContent = $pdf->getFilePath();
            $pdfTitle = $pdf->getTitle();

            // afficher une réponse appropriée
            return $this->render('generate_pdf/result.html.twig', [
                'pdfContent' => $pdfContent,
                'pdfTitle' => $pdfTitle,
            ]);
        }

        // Afficher le formulaire
        return $this->render('generate_pdf/index.html.twig', [
            'form' => $form->createView(),
            'tokens' => $this->getUser()->getTokens(),
        ]);
    }
}