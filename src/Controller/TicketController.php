<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\TypeTicket;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TicketRepository;


#[Route('/api/ticket', name: 'app_ticket_api')]
class TicketController extends AbstractController
{

    private $doctrine;
    private $serializer;

    public function __construct(
        ManagerRegistry $doctrine,
        SerializerInterface $serializer
    ) {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;
    }



    #[Route('/ticket', name: 'app_ticket')]
    public function index(): Response
    {
        return $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController',
        ]);
    }

    #[Route('/scann', name: 'app_ticket_scann')]
    public function scann(Request $request)
    {
        $message = "";

        try {
            $code = "";
            $error = "";
            $entityManager = $this->doctrine->getManager();

            $donnees = json_decode($request->getContent()) ?? $_POST;


            $event = $entityManager->getRepository(Ticket::class)->findby(['codesecret' => $donnees->codesecret]);
            if ($event == null) {
                $message = "Ticket introuvable";
                $code = 500;
                $error = true;
            }
            foreach ($event as $key => $value) {
                if ($value->getStatutrentrer() == true) {
                    $message = "Ticket deja scanné";
                    $code = 500;
                    $error = true;
                } else {
                    $value->setStatutrentrer(true);
                    $value->setDaterentrer(new \DateTime());
                    $entityManager->persist($value);
                    $entityManager->flush();
                    $message = "ticket scanné avec succes";
                    $code = 200;
                    $error = false;
                }
            }
        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = "une erreur est survenue lors du scann du ticket";
        }
        $retour = array();
        $retour['statutticket'] = ($event == null) ? "aucun ticket" : $event[0]->getStatutrentrer();
        $retour['daterentrer'] = ($event == null) ? "aucun ticket" : $event[0]->getDaterentrer();
        $retour['message'] = $message;

        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $retour : $message,
        ];
        return new Response($this->serializer->serialize($response, "json"));
    }

    #[Route('/generate/ticket/event/{idevent}', name: 'generateticketbyeventandnumber')]
    public function generateticketbyeventandnumber(Request $request, $idevent): Response
    {
        $entityManager = $this->doctrine->getManager();

        $event = $entityManager->getRepository(Event::class)->find(intval($idevent));

        foreach ($event->getTypeTickets() as $key => $value) {
            for ($i = 0; $i < $value->getNombretotal(); $i++) {

                if ($event->getNombreticket() < count($event->getTicket())) {
                    return new Response('Tentative de generation frauduleuse', 550);
                }
                $ticket = new Ticket();
                $ticket->setEvent($event);
                $ticket->setPrice($value->getPrice());
                $ticket->setCodesecret($event->getCodeevent() . '' . $this->GenerateNumberToken());
                $ticket->setCodevisuel($i + 1);
                $ticket->setStatutrentrer(false);
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
        return new JsonResponse(['code'=> 200, 'message'=>'ticket generer'], 201);

    }
    

    #[Route('/liste/event/{idevent}', name: 'getTicketAll')]
    public function getTickets(TicketRepository $ticketRepo, $idevent): JsonResponse {
        //$data = $this->doctrine->getRepository(Ticket::class)->findAll(["event_id" => intval($idevent)]);
        $data = $ticketRepo->apiFindAllByEvent($idevent);
        return new JsonResponse(['code'=> 200, 'message'=>'ticket generer', 'data'=> $data], 201);
    }


    static function GenerateNumberToken()
    {
        $characters = '0123456789';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 9; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return strtoupper($string);
    }
}
