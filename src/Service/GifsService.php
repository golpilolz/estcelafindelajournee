<?php

namespace App\Service;

class GifsService {
    public function getUrlFromKey($key) {
        return 'https://media.giphy.com/media/' . $key . '/giphy.gif';
    }
}
