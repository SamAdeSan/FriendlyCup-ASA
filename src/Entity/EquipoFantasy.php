<?php

namespace App\Entity;

use App\Repository\EquipoFantasyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipoFantasyRepository::class)]
class EquipoFantasy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'equipoFantasies')]
    private ?LigaFantasy $ligafantasy = null;

    #[ORM\ManyToOne(inversedBy: 'equipoFantasies')]
    private ?User $entrenador = null;

    #[ORM\ManyToOne(inversedBy: 'equipoFantasies')]
    private ?Jugadores $jugadores = null;

    #[ORM\Column]
    private ?int $puntos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLigafantasy(): ?LigaFantasy
    {
        return $this->ligafantasy;
    }

    public function setLigafantasy(?LigaFantasy $ligafantasy): static
    {
        $this->ligafantasy = $ligafantasy;

        return $this;
    }

    public function getEntrenador(): ?User
    {
        return $this->entrenador;
    }

    public function setEntrenador(?User $entrenador): static
    {
        $this->entrenador = $entrenador;

        return $this;
    }

    public function getJugadores(): ?Jugadores
    {
        return $this->jugadores;
    }

    public function setJugadores(?Jugadores $jugadores): static
    {
        $this->jugadores = $jugadores;

        return $this;
    }

    public function getPuntos(): ?int
    {
        return $this->puntos;
    }

    public function setPuntos(int $puntos): static
    {
        $this->puntos = $puntos;

        return $this;
    }
}
