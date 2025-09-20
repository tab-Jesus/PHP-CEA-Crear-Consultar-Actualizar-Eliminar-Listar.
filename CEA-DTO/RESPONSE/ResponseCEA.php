<?php

namespace App\Application\Response;

use App\Domain\Entity\Gasto;


class CEAResponse
{
    public string $id;
    public string $fecha;
    public float $valorTotalSinIVA;
    public float $ivaTotal;
    public float $valorTotalConIVA;
    public string $nombreUsuario;
    public string $lugar;
    public ?string $descripcion;
    public string $fechaRegistro;
    public bool $procesado;
    public bool $contabilizado;

    public function __construct(Gasto $gasto)
    {
        $this->id = $gasto->getId()->toString();
        $this->fecha = $gasto->getFecha()->format('Y-m-d');
        $this->valorTotalSinIVA = $gasto->getValorTotalSinIVA();
        $this->ivaTotal = $gasto->getIvaTotal();
        $this->valorTotalConIVA = $gasto->getValorTotalConIVA();
        $this->nombreUsuario = $gasto->getNombreUsuario();
        $this->lugar = $gasto->getLugar();
        $this->descripcion = $gasto->getDescripcion();
        $this->fechaRegistro = $gasto->getFechaRegistro()->format('Y-m-d H:i:s');
        $this->procesado = $gasto->isProcesado();
        $this->contabilizado = $gasto->isContabilizado();
    }

   
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'fecha' => $this->fecha,
            'valorTotalSinIVA' => $this->valorTotalSinIVA,
            'ivaTotal' => $this->ivaTotal,
            'valorTotalConIVA' => $this->valorTotalConIVA,
            'nombreUsuario' => $this->nombreUsuario,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion,
            'fechaRegistro' => $this->fechaRegistro,
            'procesado' => $this->procesado,
            'contabilizado' => $this->contabilizado
        ];
    }


    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT);
    }
}
?>