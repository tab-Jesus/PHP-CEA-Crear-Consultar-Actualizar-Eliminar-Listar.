<?php

namespace App\Infrastructure\Entrypoints\Rest\CEA\Response;

use App\Domain\Entity\Gasto;
use JsonSerializable;

class CEAHttpResponse implements JsonSerializable
{
    private string $id;
    private string $fecha;
    private float $valorTotalSinIVA;
    private float $ivaTotal;
    private float $valorTotalConIVA;
    private string $nombreUsuario;
    private string $lugar;
    private ?string $descripcion;
    private ?string $categoria;
    private bool $procesado;
    private bool $contabilizado;
    private string $fechaRegistro;
    private ?string $fechaProcesado;
    private ?string $fechaContabilizado;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->fecha = $data['fecha'];
        $this->valorTotalSinIVA = $data['valor_total_sin_iva'];
        $this->ivaTotal = $data['iva_total'];
        $this->valorTotalConIVA = $data['valor_total_con_iva'];
        $this->nombreUsuario = $data['nombre_usuario'];
        $this->lugar = $data['lugar'];
        $this->descripcion = $data['descripcion'] ?? null;
        $this->categoria = $data['categoria'] ?? 'general';
        $this->procesado = $data['procesado'];
        $this->contabilizado = $data['contabilizado'];
        $this->fechaRegistro = $data['fecha_registro'];
        $this->fechaProcesado = $data['fecha_procesado'] ?? null;
        $this->fechaContabilizado = $data['fecha_contabilizado'] ?? null;
    }

  
    public static function fromGasto(Gasto $gasto): self
    {
        return new self([
            'id' => $gasto->getId()->toString(),
            'fecha' => $gasto->getFecha()->format('Y-m-d'),
            'valor_total_sin_iva' => $gasto->getValorTotalSinIVA(),
            'iva_total' => $gasto->getIvaTotal(),
            'valor_total_con_iva' => $gasto->getValorTotalConIVA(),
            'nombre_usuario' => $gasto->getNombreUsuario(),
            'lugar' => $gasto->getLugar(),
            'descripcion' => $gasto->getDescripcion(),
            'procesado' => $gasto->isProcesado(),
            'contabilizado' => $gasto->isContabilizado(),
            'fecha_registro' => $gasto->getFechaRegistro()->format('Y-m-d H:i:s'),
        ]);
    }

   
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'valor_total_sin_iva' => $this->valorTotalSinIVA,
            'iva_total' => $this->ivaTotal,
            'valor_total_con_iva' => $this->valorTotalConIVA,
            'nombre_usuario' => $this->nombreUsuario,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion,
            'categoria' => $this->categoria,
            'procesado' => $this->procesado,
            'contabilizado' => $this->contabilizado,
            'fecha_registro' => $this->fechaRegistro,
            'fecha_procesado' => $this->fechaProcesado,
            'fecha_contabilizado' => $this->fechaContabilizado,
            'links' => [
            ]
        ];
    }

 
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }


    public function getId(): string { return $this->id; }
    public function getFecha(): string { return $this->fecha; }
    public function getValorTotalSinIVA(): float { return $this->valorTotalSinIVA; }
    public function getIvaTotal(): float { return $this->ivaTotal; }
    public function getValorTotalConIVA(): float { return $this->valorTotalConIVA; }
    public function getNombreUsuario(): string { return $this->nombreUsuario; }
    public function getLugar(): string { return $this->lugar; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function getCategoria(): ?string { return $this->categoria; }
    public function isProcesado(): bool { return $this->procesado; }
    public function isContabilizado(): bool { return $this->contabilizado; }
    public function getFechaRegistro(): string { return $this->fechaRegistro; }
    public function getFechaProcesado(): ?string { return $this->fechaProcesado; }
    public function getFechaContabilizado(): ?string { return $this->fechaContabilizado; }
}
?>