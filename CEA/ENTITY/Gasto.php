<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\GastoId;
use App\Domain\Exception\InvalidGastoState;
use DateTimeImmutable;
use DateTimeInterface;


class Gasto
{
    private GastoId $id;
    private DateTimeInterface $fecha;
    private float $valorTotalSinIVA;
    private float $ivaTotal;
    private float $valorTotalConIVA;
    private string $nombreUsuario;
    private string $lugar;
    private ?string $descripcion;
    private DateTimeInterface $fechaRegistro;
    private bool $procesado;
    private bool $contabilizado;

    private function __construct(
        GastoId $id,
        DateTimeInterface $fecha,
        float $valorTotalSinIVA,
        float $ivaTotal,
        float $valorTotalConIVA,
        string $nombreUsuario,
        string $lugar,
        ?string $descripcion = null
    ) {
        $this->id = $id;
        $this->setFecha($fecha);
        $this->setValorTotalSinIVA($valorTotalSinIVA);
        $this->setIvaTotal($ivaTotal);
        $this->setValorTotalConIVA($valorTotalConIVA);
        $this->setNombreUsuario($nombreUsuario);
        $this->setLugar($lugar);
        $this->setDescripcion($descripcion);
        
        $this->fechaRegistro = new DateTimeImmutable();
        $this->procesado = false;
        $this->contabilizado = false;
    }

    
    
    public static function crear(
        DateTimeInterface $fecha,
        float $valorTotalSinIVA,
        float $ivaTotal,
        float $valorTotalConIVA,
        string $nombreUsuario,
        string $lugar,
        ?string $descripcion = null
    ): self {
        $id = GastoId::generate();
        
        return new self(
            $id,
            $fecha,
            $valorTotalSinIVA,
            $ivaTotal,
            $valorTotalConIVA,
            $nombreUsuario,
            $lugar,
            $descripcion
        );
    }

    
    public static function reconstruir(
        string $id,
        DateTimeInterface $fecha,
        float $valorTotalSinIVA,
        float $ivaTotal,
        float $valorTotalConIVA,
        string $nombreUsuario,
        string $lugar,
        ?string $descripcion,
        DateTimeInterface $fechaRegistro,
        bool $procesado,
        bool $contabilizado
    ): self {
        $gastoId = GastoId::fromString($id);
        $gasto = new self(
            $gastoId,
            $fecha,
            $valorTotalSinIVA,
            $ivaTotal,
            $valorTotalConIVA,
            $nombreUsuario,
            $lugar,
            $descripcion
        );
        
        $gasto->fechaRegistro = $fechaRegistro;
        $gasto->procesado = $procesado;
        $gasto->contabilizado = $contabilizado;
        
        return $gasto;
    }

    public function getId(): GastoId
    {
        return $this->id;
    }

    public function getFecha(): DateTimeInterface
    {
        return $this->fecha;
    }

    public function getValorTotalSinIVA(): float
    {
        return $this->valorTotalSinIVA;
    }

    public function getIvaTotal(): float
    {
        return $this->ivaTotal;
    }

    public function getValorTotalConIVA(): float
    {
        return $this->valorTotalConIVA;
    }

    public function getNombreUsuario(): string
    {
        return $this->nombreUsuario;
    }

    public function getLugar(): string
    {
        return $this->lugar;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getFechaRegistro(): DateTimeInterface
    {
        return $this->fechaRegistro;
    }

    public function isProcesado(): bool
    {
        return $this->procesado;
    }

    public function isContabilizado(): bool
    {
        return $this->contabilizado;
    }

    public function setFecha(DateTimeInterface $fecha): void
    {
        $now = new DateTimeImmutable();
        if ($fecha > $now) {
            throw InvalidGastoState::invalidDate($fecha->format('Y-m-d'));
        }
        
        $this->fecha = $fecha;
    }

    public function setValorTotalSinIVA(float $valorTotalSinIVA): void
    {
        if ($valorTotalSinIVA <= 0) {
            throw InvalidGastoState::invalidValue($valorTotalSinIVA);
        }
        
        $this->valorTotalSinIVA = $valorTotalSinIVA;
    }

    public function setIvaTotal(float $ivaTotal): void
    {
        if ($ivaTotal < 0) {
            throw InvalidGastoState::invalidValue($ivaTotal);
        }
        
        $this->ivaTotal = $ivaTotal;
    }

    public function setValorTotalConIVA(float $valorTotalConIVA): void
    {
        if ($valorTotalConIVA <= 0) {
            throw InvalidGastoState::invalidValue($valorTotalConIVA);
        }
        
        $calculatedTotal = $this->valorTotalSinIVA + $this->ivaTotal;
        if (abs($calculatedTotal - $valorTotalConIVA) > 0.01) {
            throw new \DomainException('El valor total con IVA no coincide con la suma del valor sin IVA y el IVA.');
        }
        
        $this->valorTotalConIVA = $valorTotalConIVA;
    }

    public function setNombreUsuario(string $nombreUsuario): void
    {
        if (empty(trim($nombreUsuario))) {
            throw new \InvalidArgumentException('El nombre de usuario no puede estar vacío.');
        }
        
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setLugar(string $lugar): void
    {
        if (empty(trim($lugar))) {
            throw new \InvalidArgumentException('El lugar no puede estar vacío.');
        }
        
        $this->lugar = $lugar;
    }

    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

   
    public function marcarComoProcesado(): void
    {
        $this->procesado = true;
    }

    
    public function marcarComoContabilizado(): void
    {
        if (!$this->procesado) {
            throw new \DomainException('No se puede contabilizar un gasto que no ha sido procesado.');
        }
        
        $this->contabilizado = true;
    }

   
    public function actualizar(
        DateTimeInterface $fecha,
        float $valorTotalSinIVA,
        float $ivaTotal,
        float $valorTotalConIVA,
        string $lugar,
        ?string $descripcion = null
    ): void {
        if ($this->procesado) {
            throw InvalidGastoState::cannotModifyProcessedGasto($this->id->toString());
        }
        
        $this->setFecha($fecha);
        $this->setValorTotalSinIVA($valorTotalSinIVA);
        $this->setIvaTotal($ivaTotal);
        $this->setValorTotalConIVA($valorTotalConIVA);
        $this->setLugar($lugar);
        $this->setDescripcion($descripcion);
    }

 
    public function calcularIVA(float $porcentajeIVA): void
    {
        $this->ivaTotal = $this->valorTotalSinIVA * ($porcentajeIVA / 100);
        $this->valorTotalConIVA = $this->valorTotalSinIVA + $this->ivaTotal;
    }

    
    public function puedeSerEliminado(): bool
    {
        return !$this->contabilizado;
    }

  
    public function toArray(): array
    {
        return [
            'id' => $this->id->toString(),
            'fecha' => $this->fecha->format('Y-m-d'),
            'valorTotalSinIVA' => $this->valorTotalSinIVA,
            'ivaTotal' => $this->ivaTotal,
            'valorTotalConIVA' => $this->valorTotalConIVA,
            'nombreUsuario' => $this->nombreUsuario,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion,
            'fechaRegistro' => $this->fechaRegistro->format('Y-m-d H:i:s'),
            'procesado' => $this->procesado,
            'contabilizado' => $this->contabilizado
        ];
    }
}
?>