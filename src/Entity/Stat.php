<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatRepository")
 */
class Stat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $headshoots;

    /**
     * @ORM\Column(type="integer")
     */
    private $nkills;

    /**
     * @ORM\Column(type="decimal", precision=3, scale=2)
     */
    private $kd;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="stats")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeadshoots(): ?int
    {
        return $this->headshoots;
    }

    public function setHeadshoots(int $headshoots): self
    {
        $this->headshoots = $headshoots;

        return $this;
    }

    public function getNkills(): ?int
    {
        return $this->nkills;
    }

    public function setNkills(int $nkills): self
    {
        $this->nkills = $nkills;

        return $this;
    }

    public function getKd(): ?string
    {
        return $this->kd;
    }

    public function setKd(string $kd): self
    {
        $this->kd = $kd;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
