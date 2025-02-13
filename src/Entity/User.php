<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $twitch_id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column]
    private ?float $elo = null;

    #[ORM\Column]
    private ?int $money = null;

    #[ORM\Column]
    private ?int $current_horse_skin = null;

      /**
     * Many Users have Many HorseSkin.
     * @var Collection<int, HorseSkin>
     */
    #[ORM\ManyToMany(targetEntity: HorseSkin::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'users_skins')]
    protected $skins;

    public function __construct() {
        $this->skins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTwitchId(): ?int
    {
        return $this->twitch_id;
    }

    public function setTwitchId(int $twitch_id): static
    {
        $this->twitch_id = $twitch_id;

        return $this;
    }

    public function getElo(): ?float
    {
        return ceil($this->elo);
    }

    public function setElo(float $elo): static
    {
        $this->elo = $elo;

        return $this;
    }

    public function getMoney(): ?int
    {
        return $this->money;
    }

    public function setMoney(int $money): static
    {
        $this->money = $money;

        return $this;
    }

    public function getCurrentHorseSkin(): ?int
    {
        return $this->current_horse_skin;
    }

    public function setCurrentHorseSkin(int $current_horse_skin): static
    {
        $this->current_horse_skin = $current_horse_skin;

        return $this;
    }

    public function getSkins(): Collection
    {
        return $this->skins;
    }

    public function addSkin(HorseSkin $skin): self
    {
        if (!$this->skins->contains($skin)) {
            $this->skins[] = $skin;
        }
        return $this;
    }
    public function removeSkin(HorseSkin $skin): self
    {
        $this->skins->removeElement($skin);
        return $this;
    }

   
}
