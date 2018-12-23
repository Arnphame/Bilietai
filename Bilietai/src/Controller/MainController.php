<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $tickets = $this->getDoctrine()->getRepository(Ticket::class)->findAll();
        $times = $this->getDoctrine()->getRepository(TicketTime::class)->findAll();

        return $this->render('index.html.twig', [
            'controller_name' => 'MainController',
            'tickets' => $tickets,
            'times' => $times,
        ]);
    }
}
