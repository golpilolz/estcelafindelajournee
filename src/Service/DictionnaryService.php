<?php

namespace App\Service;

class DictionnaryService
{
    private $json;

    public function __construct()
    {
        $this->json = json_decode($this->loadDictionary());
    }

    public function getWord(): array
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Europe/Paris'));
        $currenttime = $datetime->format('Gis');

        $words = $this->getWords((int) $currenttime);
        $key = array_rand($words);

        $word = [
            'response' => $words[$key]->response,
            'gif' => $words[$key]->gif
        ];

        return $word;
    }

    private function getWords(int $currenttime): array {
        foreach ($this->json as $item) {
            if((int) $item->start <= $currenttime and (int) $item->end > $currenttime) {
                return $item->texts;
            }
        }
        return [];
    }

    private function loadDictionary(): string {
        return file_get_contents(__DIR__ . '/../../dictionary.json');
    }
}
