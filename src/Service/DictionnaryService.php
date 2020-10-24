<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class DictionnaryService {
  private array $json;

  private LoggerInterface $logger;

  public function __construct(LoggerInterface $logger) {
    $this->json = json_decode($this->loadDictionary());
    if (!$this->json) {
      $this->json = [];
    }
    $this->logger = $logger;
  }

  /**
   * @return array
   */
  public function getWord(): array {
    $datetime = new \DateTime();
    $datetime->setTimezone(new \DateTimeZone('Europe/Paris'));
    $currentTime = $datetime->format('Gis');

    $allWords = $words = $this->getWords((int)$currentTime);
    foreach ($words as $key => $word) {
      if (!$this->isAvailableToday($word)) {
        unset($words[$key]);
      }
    }

    if (empty($words)) {
      $words = $allWords;
    }
    $key = array_rand($words);

    return [
      'response' => $words[$key]->response,
      'gif' => $words[$key]->gif
    ];
  }

  private function getWords(int $currentTime): array {
    foreach ($this->json as $item) {
      if ((int)$item->start <= $currentTime and (int)$item->end > $currentTime) {
        return $item->texts;
      }
    }
    return [];
  }

  private function loadDictionary(): string {
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

  private function isAvailableToday(\stdClass $word): bool {
    $now = new \DateTime();
    $wordArray = str_split($word->days);

    $day = substr($now->format('D'), 0, 1);
    $wordDay = $wordArray[intval($now->format('N')) - 1];

    return ($wordDay !== '-' and $wordDay === $day);
  }
}
