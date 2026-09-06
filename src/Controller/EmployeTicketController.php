<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketEtatType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class EmployeTicketController extends AbstractController
{
    #[Route('/employe/tickets', name: 'employe_tickets')]
    public function index(
        TicketRepository $ticketRepository
    ): Response {
        $tickets = $ticketRepository->findAll();

        return $this->render('employe/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/employe/tickets/{id}', name: 'employe_ticket_show')]
    public function show(Ticket $ticket): Response
    {
        return $this->render('employe/ticket_show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    #[Route('/employe/tickets/{id}/etat', name: 'employe_ticket_etat')]
    public function editEtat(
        Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(TicketEtatType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash(
                'success',
                'L’état du ticket a été modifié avec succès.'
            );

            return $this->redirectToRoute('employe_ticket_show', [
                'id' => $ticket->getId(),
            ]);
        }

        return $this->render('employe/ticket_etat.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket,
        ]);
    }
}