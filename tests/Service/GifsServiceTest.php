<?php

namespace App\Tests\Service;

use App\Service\GifsService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GifsServiceTest extends WebTestCase
{
    public function testGetUrlFromKey(): void {
        self::bootKernel();

        $gifsService = self::getContainer()->get(GifsService::class);

        $this->assertEquals(
            'https://media.giphy.com/media/abcd/giphy.gif',
            $gifsService->getUrlFromKey('abcd')
        );
    }
}