<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class TicketController extends AbstractController
{
    #[Route('/admin/tickets', name: 'admin_tickets')]
    public function index(TicketRepository $ticketRepository): Response
    {
        $tickets = $ticketRepository->findAll();

        return $this->render('admin/tickets.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    #[Route('/admin/tickets/{id}/modifier', name: 'admin_ticket_edit')]
    public function edit(
        Ticket $ticket,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(TicketType::class, $ticket);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le ticket a été modifié avec succès.'
            );

            return $this->redirectToRoute('admin_tickets');
        }

        return $this->render('admin/ticket_edit.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket,
        ]);
    }
}