<?php

namespace App\Controller;

use App\Form\TicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Ticket;
use App\Entity\Etat;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entitymanager, Request $request ): Response
    {

    $ticket = new Ticket();

    $form = $this->createForm(TicketType::class, $ticket);

    

    $form->handleRequest($request);


    



    if($form->isSubmitted() && $form->isValid()){

    $etat = $entitymanager
        ->getRepository(Etat::class)
        ->findOneBy(['nom' => 'Nouveau']);

    $ticket->setEtat($etat);

    $entitymanager->persist($ticket);
    $entitymanager->flush();

    $this->addFlash('success', 'Votre ticket a été créé avec succès.');

    return $this->redirectToRoute('app_home');

    }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
