<?php

declare(strict_types=1);

namespace App\Service;

class GifsService {
  public function getUrlFromKey(string $key, string $file = 'giphy.gif'): string {
    return 'https://media.giphy.com/media/' . $key . '/' . $file;
  }
}
