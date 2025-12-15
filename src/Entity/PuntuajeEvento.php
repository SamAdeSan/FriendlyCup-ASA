<?php

namespace App\Entity;

use App\Repository\PuntuajeEventoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PuntuajeEventoRepository::class)]
class PuntuajeEvento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'puntuajeEventos')]
    private ?Disputas $disputa = null;

    #[ORM\ManyToOne(inversedBy: 'puntuajeEventos')]
    private ?Jugadores $jugador = null;

    #[ORM\Column]
    private ?int $puntos = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisputa(): ?Disputas
    {
        return $this->disputa;
    }

    public function setDisputa(?Disputas $disputa): static
    {
        $this->disputa = $disputa;

        return $this;
    }

    public function getJugador(): ?Jugadores
    {
        return $this->jugador;
    }

    public function setJugador(?Jugadores $jugador): static
    {
        $this->jugador = $jugador;

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
