<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\EquipoFantasyRepository;

#[ORM\Entity(repositoryClass: EquipoFantasyRepository::class)]
class EquipoFantasy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'equipoFantasies')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?LigaFantasy $ligafantasy = null;

    #[ORM\ManyToOne(inversedBy: 'equipoFantasies')]
    private ?User $entrenador = null;

    #[ORM\Column]
    private ?float $presupuesto = 100000000;

    #[ORM\ManyToMany(targetEntity: Jugadores::class)]
    #[ORM\JoinTable(name: "equipofantasy_titulares")]
    private Collection $titulares;

    #[ORM\Column]
    private ?int $puntos = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->titulares = new ArrayCollection();
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

    public function getPresupuesto(): ?float
    {
        return $this->presupuesto;
    }

    public function setPresupuesto(float $presupuesto): static
    {
        $this->presupuesto = $presupuesto;
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
    public function getTitulares(): Collection
    {
        return $this->titulares;
    }

    public function addTitular(Jugadores $jugador): self
    {
        if (!$this->titulares->contains($jugador)) {
            $this->titulares->add($jugador);
        }
        return $this;
    }
    public function removeTitular(Jugadores $jugador): self
    {
        $this->titulares->removeElement($jugador);
        return $this;
    }
}