<?php

namespace App\Entity;

use App\Repository\RaceHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RaceHistoryRepository::class)]
class RaceHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_player = null;

    #[ORM\Column]
    private ?int $id_race = null;

    #[ORM\Column]
    private ?int $place_result = null;

    #[ORM\Column]
    private ?int $elo_variation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlayer(): ?int
    {
        return $this->id_player;
    }

    public function setIdPlayer(int $id_player): static
    {
        $this->id_player = $id_player;

        return $this;
    }

    public function getIdRace(): ?int
    {
        return $this->id_race;
    }

    public function setIdRace(int $id_race): static
    {
        $this->id_race = $id_race;

        return $this;
    }

    public function getPlaceResult(): ?int
    {
        return $this->place_result;
    }

    public function setPlaceResult(int $place_result): static
    {
        $this->place_result = $place_result;

        return $this;
    }

    public function getEloVariation(): ?int
    {
        return $this->elo_variation;
    }

    public function setEloVariation(int $elo_variation): static
    {
        $this->elo_variation = $elo_variation;

        return $this;
    }
}
