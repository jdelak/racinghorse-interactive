<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GameController extends AbstractController
{
    #[Route('/lobby', name: 'lobby')]
    public function createLobby($user, $accesstoken): Response
    {
        return $this->render('game/lobby.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    #[Route('/settings', name: 'settings')]
    public function manageSettings($user, $accesstoken): Response
    {
        return $this->render('game/settings.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    #[Route('/customize', name: 'customize')]
    public function customizeHorse($user, $accesstoken): Response
    {
        return $this->render('game/customize.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }

    #[Route('/rankings', name: 'rankings')]
    public function getRanking($user, $accesstoken): Response
    {
        return $this->render('game/rankings.html.twig', [
            'controller_name' => 'GameController',
        ]);
    }
}
