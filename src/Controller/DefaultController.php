<?php

namespace App\Controller;

use App\Service\DictionnaryService;
use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {
  public function __construct(private readonly DictionnaryService $dictionnaryService)
  {
  }

  public function index(): Response {
    $word = $this->dictionnaryService->getWord();

    return $this->render('index.html.twig', [
      'word' => $word['response'],
      'gif' => $word['gif']
    ]);
  }

  public function api(GifsService $gifsService): JsonResponse {
    $word = $this->dictionnaryService->getWord();

    return new JsonResponse([
      'word' => $word['response'],
      'gif' => $gifsService->getUrlFromKey($word['gif'])
    ]);
  }
}
