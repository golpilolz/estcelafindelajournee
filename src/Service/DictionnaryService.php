<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class DictionnaryService
{
    private $json;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->json = json_decode($this->loadDictionary());

        $this->logger = $logger;
    }

    public function getWord(): array
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Europe/Paris'));
        $currenttime = $datetime->format('Gis');

        if ($datetime->format('n') === "4" and $datetime->format('j') === "1") {

            try {
                if(random_int(0,1)) {
                    return [
                        'response' => "Oui",
                        'gif' => "YtWWzfyXXeI5W"
                    ];
                }
            } catch (\Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }

        $words = $this->getWords((int) $currenttime);
        $key = array_rand($words);
        
        return [
            'response' => $words[$key]->response,
            'gif' => $words[$key]->gif
        ];
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
