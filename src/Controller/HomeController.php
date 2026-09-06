<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketPublicType;
use App\Repository\EtatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        EtatRepository $etatRepository
    ): Response {
        $ticket = new Ticket();

        $form = $this->createForm(TicketPublicType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Date d'ouverture automatique
            $ticket->setDateOuverture(new \DateTimeImmutable());

            // État automatique : Nouveau
            $etatNouveau = $etatRepository->findOneBy([
                'nom' => 'Nouveau'
            ]);

            $ticket->setEtat($etatNouveau);

            // Enregistrement
            $entityManager->persist($ticket);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre ticket a été créé avec succès.'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}