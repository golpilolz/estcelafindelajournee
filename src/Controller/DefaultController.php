<?php

namespace App\Controller;

use App\Service\DictionnaryService;
use Aws\S3\S3Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{
    /** @var  DictionnaryService */
    private $dictionnaryService;


    public function __construct(DictionnaryService $dictionnaryService)
    {
        $this->dictionnaryService = $dictionnaryService;
    }

    public function index()
    {
        $word = $this->dictionnaryService->getWord();

        return $this->render('index.html.twig', [
            'word' => $word['response'],
            'gif' => $word['gif']
        ]);
    }

    public function api() {
        $word = $this->dictionnaryService->getWord();

        return new JsonResponse([
            'word' => $word['response'],
            'gif' => $word['gif']
        ]);
    }
}
