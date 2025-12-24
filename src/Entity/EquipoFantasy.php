<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EquipoFantasyRepository;

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

    #[ORM\Column]
    private ?float $presupuesto = 100000000;

    #[ORM\Column(type: Types::JSON)]
    private array $datosAlineacion = [
        'titulares' => [],      // Array de IDs [1, 5, 9...]
        'suplentes' => [],      // Array de IDs
        'coste_compra' => []    // Mapa ID => Precio { "10": 500000 }
    ];

    #[ORM\Column]
    private ?int $puntos = 0;

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
    public function getDatosAlineacion(): array
    {
        return array_merge([
            'titulares' => [],
            'suplentes' => [],
            'coste_compra' => []
        ], $this->datosAlineacion);
    }

    public function setDatosAlineacion(array $datosAlineacion): static
    {
        $this->datosAlineacion = $datosAlineacion;
        return $this;
    }
    public function ficharJugador(int $id, float $precio): void
    {
        $this->datosAlineacion['suplentes'][] = $id;        
        $this->datosAlineacion['coste_compra'][$id] = $precio;
        $this->presupuesto -= $precio;
    }
    public function cambiarPosicion(int $id): void
    {
        $esTitular = in_array($id, $this->datosAlineacion['titulares']);
        $origen  = $esTitular ? 'titulares' : 'suplentes';
        $destino = $esTitular ? 'suplentes' : 'titulares';
        $this->datosAlineacion[$origen] = array_values(array_diff($this->datosAlineacion[$origen], [$id]));
        $this->datosAlineacion[$destino][] = $id;
    }
    public function venderJugador(int $id, float $precio): void
    {
    $total = count($this->datosAlineacion['titulares']) + count($this->datosAlineacion['suplentes']);
    $minimo = $this->getLigafantasy()->getMinimoJugadores();

    if ($total <= $minimo) {
        throw new \Exception("Mínimo de $minimo jugadores requerido.");
    }
    $this->datosAlineacion['titulares'] = array_values(array_diff($this->datosAlineacion['titulares'], [$id]));
    $this->datosAlineacion['suplentes'] = array_values(array_diff($this->datosAlineacion['suplentes'], [$id]));
    unset($this->datosAlineacion['coste_compra'][$id]);
    $this->presupuesto += $precio;
    }
    public function tieneJugador(int $idJugador): bool
    {
        // Buscamos si el ID está en titulares O en suplentes
        return in_array($idJugador, $this->datosAlineacion['titulares']) || 
            in_array($idJugador, $this->datosAlineacion['suplentes']);
    }
}
