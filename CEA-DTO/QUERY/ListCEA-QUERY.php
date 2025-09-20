<?php

namespace App\Application\Query;


class ListCEAQuery
{
    private ?string $usuario;
    private ?string $lugar;
    private ?string $fechaInicio;
    private ?string $fechaFin;
    private ?float $valorMinimo;
    private ?float $valorMaximo;
    private int $page;
    private int $limit;

    public function __construct(
        ?string $usuario = null,
        ?string $lugar = null,
        ?string $fechaInicio = null,
        ?string $fechaFin = null,
        ?float $valorMinimo = null,
        ?float $valorMaximo = null,
        int $page = 1,
        int $limit = 20
    ) {
        $this->usuario = $usuario;
        $this->lugar = $lugar;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->valorMinimo = $valorMinimo;
        $this->valorMaximo = $valorMaximo;
        $this->page = $page;
        $this->limit = $limit;
    }

    
    public function getUsuario(): ?string
    {
        return $this->usuario;
    }

    public function getLugar(): ?string
    {
        return $this->lugar;
    }

    public function getFechaInicio(): ?string
    {
        return $this->fechaInicio;
    }

    public function getFechaFin(): ?string
    {
        return $this->fechaFin;
    }

    public function getValorMinimo(): ?float
    {
        return $this->valorMinimo;
    }

    public function getValorMaximo(): ?float
    {
        return $this->valorMaximo;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->limit;
    }


    public function hasFilters(): bool
    {
        return !empty($this->usuario) || 
               !empty($this->lugar) || 
               !empty($this->fechaInicio) || 
               !empty($this->fechaFin) || 
               !is_null($this->valorMinimo) || 
               !is_null($this->valorMaximo);
    }
}
?>