<?php

namespace App\Tests\Service;

use App\Service\DictionnaryService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DictionnaryServiceTest extends TestCase
{
    #[DataProvider('parisTimeProvider')]
    public function testEveryTimeOfDayHasAWord(string $parisTime): void
    {
        $word = new DictionnaryService()->getWord(new \DateTimeImmutable($parisTime, new \DateTimeZone('Europe/Paris')));

        $this->assertNotSame('', $word['response']);
        $this->assertNotSame('', $word['gif']);
    }

    public static function parisTimeProvider(): \Generator
    {
        yield 'midnight' => ['2026-11-17 00:00:00'];
        yield 'slot boundary' => ['2026-11-17 10:00:00'];
        yield 'last second of the day' => ['2026-11-17 23:59:59'];
    }

    public function testWeekdayUsesParisTime(): void
    {
        // Saturday 00:30 in Paris is still Friday 23:30 in UTC.
        $now = new \DateTimeImmutable('2026-11-20 23:30:00', new \DateTimeZone('UTC'));

        $word = new DictionnaryService(__DIR__ . '/../fixtures/dictionary_weekdays.json')->getWord($now);

        $this->assertSame('saturday', $word['response']);
    }
}
