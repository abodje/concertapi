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

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;


#[Route('/api/event', name: 'api_event')]
class EventController extends AbstractController
{

    private $doctrine;
    public function __construct(
        ManagerRegistry $doctrine
        )
    {
        $this->doctrine = $doctrine;
    }
    #[Route('/liste', name: 'app_event')]
    public function liste(EventRepository $articlesRepo)
    {
        // On récupère la liste des articles
        $articles = $articlesRepo->apiFindAll();
    
        
        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];
    
        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];
    
        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);
    
        // On convertit en json
        $jsonContent = $serializer->serialize($articles, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
    
        // On instancie la réponse
        $response = new Response($jsonContent);
    
        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');
    
        // On envoie la réponse
        return $response;
        
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
        return new Response('ok', 201);
    
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
