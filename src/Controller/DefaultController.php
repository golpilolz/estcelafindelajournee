<?php

namespace App\Controller;

use App\Service\DictionnaryService;
use Aws\S3\S3Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index(DictionnaryService $dictionnaryService)
    {
        $reponse = $dictionnaryService->getWord();

        return $this->render('index.html.twig', [
            'reponse' => $reponse
        ]);
    }
}
