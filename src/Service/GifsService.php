<?php

namespace App\Service;

class GifsService {
  public function getUrlFromKey($key): string {
    return 'https://media.giphy.com/media/' . $key . '/giphy.gif';
  }
}
