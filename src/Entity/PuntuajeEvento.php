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
    private ?Torneo $torneo = null;

    #[ORM\Column]
    private ?int $puntos = null;

    #[ORM\Column(length: 255)]
    private ?string $evento = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTorneo(): ?Torneo
    {
        return $this->torneo;
    }

    public function setTorneo(?Torneo $torneo): static
    {
        $this->torneo = $torneo;

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

    public function getEvento(): ?string
    {
        return $this->evento;
    }

    public function setEvento(string $evento): static
    {
        $this->evento = $evento;

        return $this;
    }
}
