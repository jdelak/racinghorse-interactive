<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;
use App\Repository\HorseRepository;

final class RaceController extends AbstractController
{


    #[Route('/race', name: 'app_race')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RaceController.php',
        ]);
    }

    #[Route('/fillingrace', name: 'app_filling_race')]
    public function fillingRace(UserRepository $userRepository, HorseRepository $horseRepository): JsonResponse
    {

        $userList = $userRepository->getUsersWithCurrentSkin();
        $usersWithHorse = $this->addHorseToUsers($userList, $horseRepository);

        return $this->json([
            'users' => $usersWithHorse,
        ]);
    }

    public function addHorseToUsers(array $users, HorseRepository $horseRepository): array
    {
        // 8 is the max horses in a race, TODO : put in a constant
        $randomHorses = $horseRepository->getRandomHorses(8);
        $finalArray = array_combine($users, $randomHorses);

        return $finalArray;
    }
}
