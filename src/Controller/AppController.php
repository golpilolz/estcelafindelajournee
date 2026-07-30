<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DictionnaryService;
use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    public function __construct(private readonly \App\Service\DictionnaryService $dictionnaryService, private readonly \App\Service\GifsService $gifsService)
    {
    }
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $word = $this->dictionnaryService->getWord();
        return $this->render('index.html.twig', [
            'word' => $word['response'],
            'gif' => $word['gif']
        ]);
    }

    #[Route('/api', name: 'app_api')]
    public function api(): JsonResponse
    {
        $word = $this->dictionnaryService->getWord();
        return new JsonResponse([
            'word' => $word['response'],
            'gif' => $this->gifsService->getUrlFromKey($word['gif'])
        ]);
    }
}
