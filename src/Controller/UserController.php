<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'api_user')]

class UserController extends AbstractController
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
    #[Route('/liste', name: 'api_user_liste')]
    public function liste(UserRepository $articlesRepo)
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
}
