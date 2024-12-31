<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class DictionnaryService
{
    public function __construct()
    {
//        try {
//            $this->json = json_decode($this->loadDictionary(), true, flags: JSON_THROW_ON_ERROR);
//        } catch (\JsonException $e) {
//            $this->json = [];
//            $this->logger->error($e->getMessage());
//        }
    }

    /**
     * @return array{response: string, gif: string}
     */
    public function getWord(): array
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Europe/Paris'));
        $currentTime = $datetime->format('Gis');

        $allWords = $words = $this->getWords((int)$currentTime);

        foreach ($words as $key => $word) {
            if (!$this->isAvailableToday($word)) {
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
     * @param int $currentTime
     * @return array<string, array{days: string, response: string, gif: string}>
     */
    private function getWords(int $currentTime): array
    {
        /** @var array<int, array{start: string, end: string, texts: array<string, array{days: string, response: string, gif: string}>}> $items */
        $items = json_decode($this->loadDictionary(), true);

        foreach ($items as $item) {
            if ((int)$item['start'] <= $currentTime && (int)$item['end'] > $currentTime) {
                return $item['texts'];
            }
        }
        return [];
    }

    private function loadDictionary(): string
    {
        $jsonFile = file_get_contents(__DIR__ . '/../../dictionary.json');

        if ($jsonFile) {
            return $jsonFile;
        }
        return '[{
            "start": "000000",
            "end": "235959",
            "texts": [{
              "days" => "MTWTFSS",
              "response": "Erreur de chargement du dictionnaire.",
              "gif": "dlMIwDQAxXn1K"
            }]
        }]';
    }

    /**
     * @param array{days: string, response: string, gif: string} $word
     */
    private function isAvailableToday(array $word): bool
    {
        $now = new \DateTime();
        $wordArray = str_split((string)$word['days']);

        $day = substr($now->format('D'), 0, 1);
        $wordDay = $wordArray[(int)$now->format('N') - 1];

        return ($wordDay !== '-' && $wordDay === $day);
    }
}
