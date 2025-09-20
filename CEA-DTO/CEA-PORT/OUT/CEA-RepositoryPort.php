<?php

namespace App\Application\Port\Out;

use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;


interface GastoRepositoryPort
{
 
    public function save(Gasto $gasto): void;


    public function findById(GastoId $id): ?Gasto;

    public function findAll(): array;

    
    public function findByFilters(
        ?string $usuario = null,
        ?string $lugar = null,
        ?string $fechaInicio = null,
        ?string $fechaFin = null,
        ?float $valorMinimo = null,
        ?float $valorMaximo = null,
        int $limit = 20,
        int $offset = 0
    ): array;

    
    public function countByFilters(
        ?string $usuario = null,
        ?string $lugar = null,
        ?string $fechaInicio = null,
        ?string $fechaFin = null,
        ?float $valorMinimo = null,
        ?float $valorMaximo = null
    ): int;

  
    public function delete(GastoId $id): bool;

  
    public function exists(GastoId $id): bool;

    public function findByUsuario(string $usuario, int $limit = 20, int $offset = 0): array;

  
    public function findByFechaRange(string $fechaInicio, string $fechaFin, int $limit = 20, int $offset = 0): array;

   
    public function getEstadisticas(
        ?string $usuario = null,
        ?string $fechaInicio = null,
        ?string $fechaFin = null
    ): array;

 
    public function findByLugar(string $lugar, int $limit = 20, int $offset = 0): array;


    public function findPaginated(int $page = 1, int $limit = 20): array;
}
?>