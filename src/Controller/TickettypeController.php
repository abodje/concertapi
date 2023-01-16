<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TypeTicket;
use App\Repository\TypeTicketRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/typeticket', name: 'app_typeticket_api')]
class TickettypeController extends AbstractController
{

    private $doctrine;
    private $serializer;

    public function __construct(
        ManagerRegistry $doctrine,SerializerInterface $serializer
        )
    {
        $this->doctrine = $doctrine;
        $this->serializer = $serializer;

    }
    #[Route('/tickettype', name: 'app_typeticket')]
    public function index(): Response
    {
        return $this->render('tickettype/index.html.twig', [
            'controller_name' => 'TickettypeController',
        ]);
    }


    #[Route('/liste', name: 'app_tickettype_liste')]
    public function liste(TypeTicketRepository $articlesRepo): Response
    {
        $code = 200;
        $error = false;
        $articles = $articlesRepo->apiFindAll();
    
       
    
        // On instancie la réponse
       
    
        // On envoie la réponse
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $articles: $articles    ,
        ];
        // On retourne la confirmation
         return new Response($this->serializer->serialize($response, "json"));
    }


    #[Route('/ajouter', name: 'app_tickettype_ajouter', methods: ['POST'])]
    public function addTypeticket(Request $request,FileUploader $fileUploader)
 {
    // On vérifie si la requête est une requête Ajax
         // On instancie un nouvel article
        $code = 200;
        $error = false;
        $article = new TypeTicket();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent(), true) ?? $_POST;
        $donnees = (object)$donnees;
        $idevent  = $donnees->idevent;
        $user = $this->doctrine->getRepository(Event::class)->findOneBy(["id" => intval($idevent)]);
        $article->setDesignation($donnees->designation);
        $article->setDescription($donnees->description);
        $article->setPrice($donnees->price);
        $article->setStatutticket(true);
        $article->setNombretotal($donnees->nombretotal);
        $article->setTypeticketperconcert($user);
        // On sauvegarde en base
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($article);
        $entityManager->flush();
        $response = [
            'code' => $code,
            'error' => $error,
            'data' => $code == 200 ? $article->getDesignation(): $article    ,
        ];
        // On retourne la confirmation
         return new Response($this->serializer->serialize($response, "json"));

}
    
}
