<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\TypeTicket;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/ticket', name: 'app_ticket_api')]
class TicketController extends AbstractController
{

    private $doctrine;
    public function __construct(
        ManagerRegistry $doctrine
        )
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

 
    #[Route('/generate/ticket/event/{idevent}', name: 'generateticketbyeventandnumber')]
    public function generateticketbyeventandnumber(Request $request,$idevent): Response
    {
        $entityManager = $this->doctrine->getManager();

        $event = $entityManager->getRepository(Event::class)->find(intval($idevent));
     // dump($typeticket->getNombretotal());
 foreach ($event->getTypeTickets() as $key => $value) {
      for ($i=0; $i < $value->getNombretotal() ; $i++) { 
        
        if($event->getNombreticket() < count($event->getTicket())){
            return new Response('Tentative de generation frauduleuse', 550);
        }
        $ticket = new Ticket();
        $ticket->setEvent($event);
        $ticket->setPrice($value->getPrice());
        $ticket->setCodesecret($event->getCodeevent().''.$this->GenerateNumberToken());
        $ticket->setCodevisuel($i+1);
        $ticket->setDategeneration(new \DateTime());
        $ticket->setTypeticket($value);
        $entityManager->persist($ticket);
        $entityManager->flush();
    }
    
}
   


      
  
         // On sauvegarde en base
      

       // $ticket = $entityManager->getRepository(Ticket::class)->find(intval($idticket));
        //$article->setTicket($ticket);
   
        // On retourne la confirmation
        return new Response('ok', 201);
        
    }


    static function GenerateNumberToken()
    {
        $characters = '0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 9; $i++) {
            $string .= $characters[mt_rand(0, $max) ];
        }
        return strtoupper($string);
    }

}
