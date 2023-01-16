<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/event', name: 'api_event')]
class EventController extends AbstractController
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
   
    #[Route('/liste', name: 'app_event')]
    public function liste(EventRepository $articlesRepo)
    {
        // On récupère la liste des articles
        $articles = $articlesRepo->apiFindAll();
    
       
    
        // On instancie la réponse
      

        $response = [
            'code' => 200,
            'error' => false,
            'data' => $articles    ,
        ];
         return new Response($this->serializer->serialize($response, "json"));
        
    }


    #[Route('/listetypeticketbyevent/{id}', name: 'app_event_listetypeticketbyevent')]
    public function listetypeticketbyevent(EventRepository $articlesRepo,$id)
    {
        // On récupère la liste des articles
        $articles = $articlesRepo->gettypeticketbyevent($id);
        // On instancie la réponse
        $response = [
            'code' => 200,
            'error' => false,
            'data' => $articles    ,
        ];
         return new Response($this->serializer->serialize($response, "json"));
    }

    #[Route('/ajouter', name: 'app_event_ajouter', methods: ['POST'])]
    public function addEvent(Request $request,FileUploader $fileUploader)
 {
    // On vérifie si la requête est une requête Ajax
         // On instancie un nouvel article
        $article = new Event();

        // On décode les données envoyées
        $donnees = json_decode($request->getContent() ) ?? $_POST;
 
       
   
            
        $fileName2 = $this->upload_files('imgconcert', $request->files->get('image'), $fileUploader);
        $article->setImage($fileName2);
 
        $article->setDesignation($donnees['designation']);
        $article->setDescription($donnees['description']);
        $article->setStatutevent($donnees['statutevent']);
        $article->setNombreticket($donnees['nombreticket']);
        $article->setCodeevent($donnees['codeevent']);
        $article->setDateCreation(new \DateTime());
        $article->setDateEvent(new \DateTime());
        $article->setDatefinEvenet(new \DateTime());

 
        // On sauvegarde en base
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($article);
        $entityManager->flush();

        // On retourne la confirmation
 
        $response = [
            'code' => 200,
            'error' => false,
            'data' => $article->getId()    ,
        ];
         return new Response($this->serializer->serialize($response, "json"));
    
}


public function upload_files($folder, $file, FileUploader $fileUploader) {
    $ds = DIRECTORY_SEPARATOR;
    $uploadDir = $this->getParameter('kernel.project_dir')
        . $ds."public".$ds."uploads".$ds.$folder.$ds;
    $fileName = '';
    if ($file) {
        $fileUploader->setTargetDirectory($uploadDir);
        $fileName = $fileUploader->upload($file);
    }
    return $fileName;
}
}
