<?php

namespace App\Entity;

use App\Repository\EquiposRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquiposRepository::class)]
class Equipos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'equipos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Torneo $torneo = null;

    #[ORM\OneToMany(targetEntity: Jugadores::class, mappedBy: 'equipo', cascade: ['persist', 'remove'])]
    private Collection $jugadores;

    #[ORM\OneToMany(targetEntity: Disputas::class, mappedBy: 'equipo1', cascade: ['persist', 'remove'])]
    private Collection $disputasComoLocal;

    #[ORM\OneToMany(targetEntity: Disputas::class, mappedBy: 'equipo2', cascade: ['persist', 'remove'])]
    private Collection $disputasComoVisitante;

    #[ORM\Column]
    private ?int $puntos = 0;

    public function __construct()
    {
        $this->jugadores = new ArrayCollection();
        $this->disputasComoLocal = new ArrayCollection();
        $this->disputasComoVisitante = new ArrayCollection();
    }
    public function getId(): ?int { return $this->id; }
    public function getNombre(): ?string { return $this->nombre; }
    public function setNombre(string $nombre): static { $this->nombre = $nombre; return $this; }
    public function getTorneo(): ?Torneo { return $this->torneo; }
    public function setTorneo(?Torneo $torneo): static { $this->torneo = $torneo; return $this; }
    public function getJugadores(): Collection { return $this->jugadores; }
    public function addJugadore(Jugadores $jugadore): static
    {
        if (!$this->jugadores->contains($jugadore)) {
            $this->jugadores->add($jugadore);
            $jugadore->setEquipo($this);
        }
        return $this;
    }
    public function getDisputasComoLocal(): Collection { return $this->disputasComoLocal; }
    public function addDisputaComoLocal(Disputas $disputa): static
    {
        if (!$this->disputasComoLocal->contains($disputa)) {
            $this->disputasComoLocal->add($disputa);
            $disputa->setEquipo1($this);
        }
        return $this;
    }
    public function getDisputasComoVisitante(): Collection { return $this->disputasComoVisitante; }
    public function addDisputaComoVisitante(Disputas $disputa): static
    {
        if (!$this->disputasComoVisitante->contains($disputa)) {
            $this->disputasComoVisitante->add($disputa);
            $disputa->setEquipo2($this); 
        }
        return $this;
    }
    public function getTodasLasDisputas(): array
    {
        return array_merge(
            $this->disputasComoLocal->toArray(),
            $this->disputasComoVisitante->toArray()
        );
    }
    public function getPuntos(): ?int { return $this->puntos; }
    public function setPuntos(int $puntos): static { $this->puntos = $puntos; return $this; }
}
