<?php

namespace App\Twig;

use App\Service\GifsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension {
    /** @var GifsService */
    private $gifsService;

    public function __construct(GifsService $gifsService)
    {
        $this->gifsService = $gifsService;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('giphy', [$this, 'giphy']),
        ];
    }

    public function giphy($key) {
        return $this->gifsService->getUrlFromKey($key);
    }
}
