<?php

namespace App\Twig;

use App\Service\GifsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {
  /** @var GifsService */
  private GifsService $gifsService;

  public function __construct(GifsService $gifsService) {
    $this->gifsService = $gifsService;
  }

  public function getFilters(): array {
    return [
      new TwigFilter('giphy', [$this, 'giphy']),
    ];
  }

  public function giphy(string $key): string {
    return $this->gifsService->getUrlFromKey($key);
  }
}
