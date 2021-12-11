<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayRepository")
 */
class Play
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Map", inversedBy="plays")
     */
    private $map;

    /**
     * @ORM\Column(type="integer")
     */
    private $idopponent;

    /**
     * @ORM\Column(type="integer")
     */
    private $userkills;

    /**
     * @ORM\Column(type="integer")
     */
    private $opponentkills;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="plays")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $winner_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $loser_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMap(): ?Map
    {
        return $this->map;
    }

    public function setMap(?Map $map): self
    {
        $this->map = $map;

        return $this;
    }

    public function getIdopponent(): ?int
    {
        return $this->idopponent;
    }

    public function setIdopponent(int $idopponent): self
    {
        $this->idopponent = $idopponent;

        return $this;
    }

    public function getUserkills(): ?int
    {
        return $this->userkills;
    }

    public function setUserkills(int $userkills): self
    {
        $this->userkills = $userkills;

        return $this;
    }

    public function getOpponentkills(): ?int
    {
        return $this->opponentkills;
    }

    public function setOpponentkills(int $opponentkills): self
    {
        $this->opponentkills = $opponentkills;

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

    public function getWinnerId(): ?int
    {
        return $this->winner_id;
    }

    public function setWinnerId(int $winner_id): self
    {
        $this->winner_id = $winner_id;

        return $this;
    }

    public function getLoserId(): ?int
    {
        return $this->loser_id;
    }

    public function setLoserId(int $loser_id): self
    {
        $this->loser_id = $loser_id;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }
}
