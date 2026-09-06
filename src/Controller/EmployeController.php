<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class EmployeController extends AbstractController
{
    #[Route('/employe', name: 'employe_home')]
    public function index(): Response
    {
        return $this->render('employe/index.html.twig');
    }
}