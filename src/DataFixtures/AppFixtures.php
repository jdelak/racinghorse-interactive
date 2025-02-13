<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Horse;
use App\Entity\HorseSkin;
use DateTimeImmutable;

class AppFixtures extends Fixture
{

    public const HORSE_SKIN_REFERENCE = 0;

    public function load(ObjectManager $manager): void
    {

        // create the skins
        $skin1 = new HorseSkin();
        $skin1->setImage('horse_black.png');
        $skin1->setPrice(0);
        $skin1->setCreatedAt(new DateTimeImmutable());
        $manager->persist($skin1);
        $skin2 = new HorseSkin();
        $skin2->setImage('horse_white.png');
        $skin2->setPrice(0);
        $skin2->setCreatedAt(new DateTimeImmutable());
        $manager->persist($skin2);

        //create 10 Horses
        for ($i = 0; $i < 10; $i++){
            $horse = new Horse();
            $horse->setName('Horse'.$i);
            $horse->setEndurance(rand(40,60));
            $horse->setAcceleration(rand(40,60));
            $horse->setMinSpeed(rand(40,60));
            $horse->setMaxSpeed(rand(40,60));
            $horse->setMaxRaces(rand(300, 500));
            $horse->setCurrentRaces(0);
            $horse->setIsRetired(false);

            $manager->persist($horse);
        }

        //create 8 user
        for ($j = 0; $j < 8; $j++){
            $user = new User();
            $user->setEmail('player'.$j.'@mail.com');
            $user->setUsername('Player'.$j);
            // plainpassword = '1234';
            $user->setPassword('$2y$13$bA7Ywj1Qm7qQaH3Pp2yFxu8ktDp84Ymk/Ga6leK2T2ZnqMfchhZ0G');
            $user->setElo(1000);
            $user->setMoney(0);
            $user->setAccelerationBoost(0);
            $user->setEnduranceBoost(0);
            $user->setMinSpeedBoost(0);
            $user->setMaxSpeedBoost(0);
            $user->setAvailablePoints(0);
            $user->setCurrentHorseSkin(rand(1,2));
            $user->setEnergy(10);
            $manager->persist($user);
        }

        $manager->flush();
       
    }
}
