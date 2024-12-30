<?php

namespace App\Controller;

use App\Service\DictionnaryService;
use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_')]
class AppController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(DictionnaryService $dictionnaryService): Response
    {
        $word = $dictionnaryService->getWord();

        return $this->render('index.html.twig', [
            'word' => $word['response'],
            'gif' => $word['gif']
        ]);
    }

    #[Route('/api', name: 'api')]
    public function api(DictionnaryService $dictionnaryService, GifsService $gifsService): JsonResponse
    {
        $word = $dictionnaryService->getWord();

        return new JsonResponse([
            'word' => $word['response'],
            'gif' => $gifsService->getUrlFromKey($word['gif'])
        ]);
    }
}
