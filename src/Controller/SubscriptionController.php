<?php

namespace App\Controller;

use App\Entity\Subscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscription', name: 'app_subscription')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        // get the subscriptions options
        $free = $entityManager->getRepository(Subscription::class)->find(2);
        $pro = $entityManager->getRepository(Subscription::class)->find(3);
        $entreprise = $entityManager->getRepository(Subscription::class)->find(4);

        // get the actual user subscription
        $user = $this->getUser();
        $subscription = $user->getSubscription();
        $subscription_id = $subscription->getId();


        return $this->render('subscription/index.html.twig', [
            'free' => $free,
            'pro' => $pro,
            'entreprise' => $entreprise,
            'subscriptionId' => $subscription_id,
        ]);
    }
    #[Route('/subscription/{id}', name: 'change_subscription')]
    public function index2(Subscription $subscription, EntityManagerInterface $entityManager): Response
    {
        // get the actual user subscription
        $user = $this->getUser();

        // set the new subscription
        $user -> setSubscription($subscription);

        // get the new tokens limit
        $tokens = $subscription->getPdfLimit();
        $user -> setTokens($tokens);

        // save the new subscription and redirect to the profile page
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_profile');
    }
}
