<?php

namespace App\Controller;

use App\Service\DictionnaryService;
use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {
  /** @var  DictionnaryService */
  private DictionnaryService $dictionnaryService;

  public function __construct(DictionnaryService $dictionnaryService) {
    $this->dictionnaryService = $dictionnaryService;
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
