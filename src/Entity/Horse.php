<?php

namespace App\Entity;


class Horse
{

    private ?string $name = null;
    private ?int $min_speed = null;
    private ?int $max_speed = null;
    private ?int $endurance = null;
    private ?int $acceleration = null;
    private ?int $horse_skin = null;


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getMinSpeed(): ?int
    {
        return $this->min_speed;
    }

    public function setMinSpeed(int $min_speed): static
    {
        $this->min_speed = $min_speed;

        return $this;
    }

    public function getMaxSpeed(): ?int
    {
        return $this->max_speed;
    }

    public function setMaxSpeed(int $max_speed): static
    {
        $this->max_speed = $max_speed;

        return $this;
    }

    public function getEndurance(): ?int
    {
        return $this->endurance;
    }

    public function setEndurance(int $endurance): static
    {
        $this->endurance = $endurance;

        return $this;
    }

    public function getAcceleration(): ?int
    {
        return $this->acceleration;
    }

    public function setAcceleration(int $acceleration): static
    {
        $this->acceleration = $acceleration;

        return $this;
    }

    public function getHorseSkin(): ?int
    {
        return $this->horse_skin;
    }

    public function setHorseSkin(int $horse_skin): static
    {
        $this->horse_skin = $horse_skin;

        return $this;
    }

}
