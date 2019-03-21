<?php

namespace App\Service;

use Aws\S3\S3Client;
use rfreebern\Giphy;

class DictionnaryService
{
    /** @var S3Client */
    private $s3client;

    private $json;

    public function __construct(S3Client $s3Client)
    {
        $this->s3client = $s3Client;

        $result = $this->s3client->getObject([
            'Bucket' => 'estcelafindelajournee',
            'Key' => 'dictionary.json',
            'Body'   => 'this is the body!',
        ]);
        $this->json = json_decode($result['Body']->getContents());
    }

    public function getWord(): array
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Europe/Paris'));
        $currenttime = $datetime->format('Gis');

        $words = $this->getWords($currenttime);
        $key = array_rand($words);

        $word = [
            'response' => $words[$key]->response,
            'gif' => $words[$key]->gif
        ];

        return $word;
    }

    private function getWords(int $currenttime): array {
        foreach ($this->json as $item) {
            if(intval($item->start) <= $currenttime and intval($item->end) > $currenttime) {
                return $item->texts;
            }
        }
        return [];
    }
}
