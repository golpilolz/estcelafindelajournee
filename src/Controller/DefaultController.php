<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index()
    {
        $datetime = new \DateTime();
        $currenttime = $datetime->format('Gis');

        if ($datetime->format('w') === 0 or $datetime->format('w') === 6) {
            $reponse = "Mais c'est le weekend";
        } else {
            $reponse = "Tu peux partir !";

            if ($currenttime < 80000) {
                $reponse = "Elle a pas encore commencée !";
            } else if ($currenttime < 160000) {
                $reponse = "Non.";
            } else if ($currenttime < 180000) {
                $reponse = "Bientôt ...";
            } else if ($currenttime > 200000) {
                $reponse = "Toujours pas partit ???";
            }
        }


        return $this->render('index.html.twig', [
            'reponse' => $reponse
        ]);
    }
}
