<?php

namespace App\Entity;

use App\Repository\DisputasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisputasRepository::class)]
class Disputas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $resultado = null;

    // Bidirectional association: equipo1 ↔ disputasComoLocal
    #[ORM\ManyToOne(targetEntity: Equipos::class, inversedBy: 'disputasComoLocal')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipos $equipo1 = null;

    // Bidirectional association: equipo2 ↔ disputasComoVisitante
    #[ORM\ManyToOne(targetEntity: Equipos::class, inversedBy: 'disputasComoVisitante')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Equipos $equipo2 = null;

    #[ORM\ManyToOne(targetEntity: Equipos::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Equipos $ganador = null;

    #[ORM\ManyToOne(targetEntity: Torneo::class, inversedBy: 'disputas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Torneo $torneo = null;

    public function getId(): ?int { return $this->id; }
    public function getResultado(): ?string { return $this->resultado; }
    public function setResultado(string $resultado): static { $this->resultado = $resultado; return $this; }

    public function getEquipo1(): ?Equipos { return $this->equipo1; }
    public function setEquipo1(?Equipos $equipo1): static
    {
        $this->equipo1 = $equipo1;
        if ($equipo1) $equipo1->addDisputaComoLocal($this); // maintain bidirectional link
        return $this;
    }

    public function getEquipo2(): ?Equipos { return $this->equipo2; }
    public function setEquipo2(?Equipos $equipo2): static
    {
        $this->equipo2 = $equipo2;
        if ($equipo2) $equipo2->addDisputaComoVisitante($this); // maintain bidirectional link
        return $this;
    }

    public function getGanador(): ?Equipos { return $this->ganador; }
    public function setGanador(?Equipos $ganador): static { $this->ganador = $ganador; return $this; }

    public function getTorneo(): ?Torneo { return $this->torneo; }
    public function setTorneo(?Torneo $torneo): static
    {
        $this->torneo = $torneo;
        if ($torneo) $torneo->addDisputa($this); // assuming Torneo has addDisputa()
        return $this;
    }
}
