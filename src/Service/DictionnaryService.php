<?php

namespace App\Service;

class DictionnaryService
{
    public function __construct(private readonly string $dictionaryPath = __DIR__ . '/../../dictionary.json')
    {
    }

    /**
     * @return array{response: string, gif: string}
     */
    public function getWord(\DateTimeInterface $now = new \DateTimeImmutable()): array
    {
        $now = \DateTimeImmutable::createFromInterface($now)->setTimezone(new \DateTimeZone('Europe/Paris'));

        $allWords = $words = $this->getWords((int)$now->format('Gis'));

        foreach ($words as $key => $word) {
            if (!$this->isAvailableOn($word, $now)) {
                unset($words[$key]);
            }
        }

        if ($words === []) {
            $words = $allWords;
        }
        $key = array_rand($words);

        return [
            'response' => $words[$key]['response'],
            'gif' => $words[$key]['gif']
        ];
    }

    /**
     * @return array<string, array{days: string, response: string, gif: string}>
     */
    private function getWords(int $currentTime): array
    {
        /** @var array<int, array{start: string, end: string, texts: array<string, array{days: string, response: string, gif: string}>}> $items */
        $items = json_decode((string) file_get_contents($this->dictionaryPath), true, flags: JSON_THROW_ON_ERROR);

        foreach ($items as $item) {
            if ((int)$item['start'] <= $currentTime && (int)$item['end'] > $currentTime) {
                return $item['texts'];
            }
        }
        return [];
    }

    /**
     * @param array{days: string, response: string, gif: string} $word
     */
    private function isAvailableOn(array $word, \DateTimeImmutable $now): bool
    {
        $wordArray = str_split($word['days']);

        $day = substr($now->format('D'), 0, 1);
        $wordDay = $wordArray[(int)$now->format('N') - 1];

        return ($wordDay !== '-' && $wordDay === $day);
    }
}
