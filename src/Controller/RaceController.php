<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\HorseRepository;
use App\Services\TwitchService;
use App\Entity\Horse;

final class RaceController extends AbstractController
{

    private $twitchService;

    public function __construct(TwitchService $twitchService)
    {
        $this->twitchService = $twitchService;
    }

    #[Route('/race', name: 'race')]
    public function fillingRace(Request $request): Response
    {
        $horseList = [];
        $racers = json_decode($request->get('racers'));
        foreach($racers as $racer){
            $horse = New Horse();
            $horse->setName($racer);
            $horse->setMinSpeed(rand(30,50));
            $horse->setMaxSpeed(rand(50,90));
            $horse->setEndurance(rand(40,80));
            $horse->setAcceleration(rand(40,80));
            $horse->setHorseSkin(rand(1,4));
            $horseList[] = $horse;
        }

        $session = $request->getSession();
        $twitch_client_id = $this->getParameter('client_id');
        $twitch_client_secret = $this->getParameter('client_secret');
        
        $helixGuzzleClient = new \TwitchApi\HelixGuzzleClient($twitch_client_id);
        $twitchApi = new \TwitchApi\TwitchApi($helixGuzzleClient, $twitch_client_id, $twitch_client_secret);
        
        if ($session->get('access_token') === null) {
            return $this->redirectToRoute('home');

        } else {
            $twitch_access_token = $session->get('access_token');
            $user = $this->twitchService->getTwitchUser($twitch_access_token, $twitchApi);

        }

        return $this->render('game/race.html.twig', [
            'user' => $user,
            'horses' => $horseList
        ]);
     
       
    }

   
}
