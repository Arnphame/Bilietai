<?php

namespace App\Controller;

use App\Entity\TicketTime;
use Doctrine\Common\Collections\ArrayCollection;
use function Sodium\add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ticket;
use App\Form\TicketType;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket/create", name="create_ticket")
     */
    public function createTicket(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() == 3) {
                $em = $this->getDoctrine()->getManager();
                $ticket = new Ticket();
                $timeArray = new ArrayCollection();

                $form = $this->createForm(TicketType::class, $ticket);

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $ticketTimes = $form->get('ticketTimes')->getData();

                    foreach ($ticketTimes as $time) {
                        if($time->getAvailable() < 1){
                            return $this->render(
                                'create_ticket.html.twig',
                                array('form' => $form->createView(),
                                    'error' => "Neteisingas bilietų kiekis")
                            );
                        }
                        $ticket->addTicketTime($time);
                    }

                    $em->persist($ticket);
                    $em->flush();

                   return $this->redirectToRoute('main');
                }
                return $this->render(
                    'create_ticket.html.twig',
                    array('form' => $form->createView())
                );
            }
        }
        return $this->redirectToRoute('main');
    }
    /**
     * @Route("/ticket/{id}", name="ticket")
     */
    public function showTicket($id)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            if ($ticket) {
                return $this->render(
                    'ticket.html.twig',
                    array('ticket' => $ticket,)
                );
            }
            else return $this->redirectToRoute('main');
        }
        return $this->redirectToRoute('main');
    }
    /**
     * @Route("/ticket/buy/{id}/", name="buy_ticket")
     */
    public function buyTicket($id, Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();
            $date = $request->query->get('time');
            dump($date);
            $time = $this->getDoctrine()->getRepository(TicketTime::class)->findOneBy(['id' => $date]);
            $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' => $id]);

            if ($ticket) {
                if ($time->isAvailable()) {

                    $em = $this->getDoctrine()->getManager();
                    $count = $time->getTaken();
                    $count = $count + 1;
                    $time->setTaken($count);

                    $ticket->addUser($user);
                    $user->addUserTicket($ticket);
                    $user->addTicketTime($time);
                    $time->addUser($user);
                    $em->persist($ticket);
                    $em->flush();
                    return $this->redirectToRoute('userTickets');
                }
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/mytickets", name="userTickets")
     */
    public function userTickets()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();

            if ($user) {
                return $this->render(
                    'userticket.html.twig',
                    array('user' => $user,)
                );
            }
        }
        return $this->redirectToRoute('main');
    }
    /**
     * @Route("/mytickets/cancel/{id}", name="cancelTicket")
     */
    public function cancelTicket(Request $request, $id)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $this->getUser();

            if ($user) {
                $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findOneBy(['id' => $id]);
                $time = $this->getDoctrine()->getRepository(TicketTime::class)->findOneBy(['ticket' => $id]);
                if($ticket->UserContains($user)){
                    $em = $this->getDoctrine()->getManager();
                    $user->removeTicketTime($time);
                    $user->removeUserTicket($ticket);
                    $count = $time->getTaken();
                    $count = $count - 1;
                    $time->setTaken($count);

                    $em->flush();

                    return $this->redirectToRoute('userTickets');

                }
            }
        }
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/statistics", name="statistics")
     */
    public function ShowStatistics()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            if ($this->getUser()->getrole() >= 2) {

                $time = $this->getDoctrine()->getRepository(TicketTime::class)->findAll();
                $ticket = $this->getDoctrine()->getRepository(Ticket::class)->findAll();

                return $this->render(
                    'statistics.html.twig',
                    array(
                        'time' => $time,
                        'ticket' => $ticket,
                    ));
            }
        }
        return $this->redirectToRoute('main');
    }
}
