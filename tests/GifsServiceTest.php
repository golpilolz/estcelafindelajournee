<?php

namespace App\Tests;


use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GifsServiceTest extends WebTestCase
{
    public function testGetUrlFromKey() {
        self::bootKernel();
        $gifsService = self::$container->get(GifsService::class);

        $this->assertEquals(
            'https://media.giphy.com/media/abcd/giphy.gif',
            $gifsService->getUrlFromKey('abcd')
        );
    }
}