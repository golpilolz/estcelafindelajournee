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

    if ($datetime->format('n') === "4" and $datetime->format('j') === "1") {

      try {
        if (random_int(0, 1)) {
          return [
            'response' => "Oui",
            'gif' => "YtWWzfyXXeI5W"
          ];
        }
      } catch (\Exception $e) {
        $this->logger->error($e->getMessage());
      }
    }

    $words = $this->getWords((int)$currentTime);
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
                "response": "Erreur de chargement du dictionnaire.",
                "gif": "dlMIwDQAxXn1K"
            }]
        }]';
  }
}
