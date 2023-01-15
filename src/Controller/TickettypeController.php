<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TickettypeController extends AbstractController
{
    #[Route('/tickettype', name: 'app_tickettype')]
    public function index(): Response
    {
        return $this->render('tickettype/index.html.twig', [
            'controller_name' => 'TickettypeController',
        ]);
    }
}
