<?php

namespace App\Application\Service;

use App\Application\Port\In\ListGastosUseCase;
use App\Application\Port\Out\GastoRepositoryPort;


class ListGastosService implements ListGastosUseCase
{
    private GastoRepositoryPort $gastoRepository;

    public function __construct(GastoRepositoryPort $gastoRepository)
    {
        $this->gastoRepository = $gastoRepository;
    }

   
    public function listAllGastos(): array
    {
        return $this->gastoRepository->findAll();
    }

  
    public function listGastos(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $usuario = $filters['usuario'] ?? null;
        $lugar = $filters['lugar'] ?? null;
        $fechaInicio = $filters['fechaInicio'] ?? null;
        $fechaFin = $filters['fechaFin'] ?? null;
        $valorMinimo = isset($filters['valorMinimo']) ? (float) $filters['valorMinimo'] : null;
        $valorMaximo = isset($filters['valorMaximo']) ? (float) $filters['valorMaximo'] : null;

        $page = max(1, $page);
        $limit = max(1, min(100, $limit));
        $offset = ($page - 1) * $limit;

        $gastos = $this->gastoRepository->findByFilters(
            $usuario,
            $lugar,
            $fechaInicio,
            $fechaFin,
            $valorMinimo,
            $valorMaximo,
            $limit,
            $offset
        );

        $total = $this->gastoRepository->countByFilters(
            $usuario,
            $lugar,
            $fechaInicio,
            $fechaFin,
            $valorMinimo,
            $valorMaximo
        );

        return [
            'gastos' => $gastos,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => $limit > 0 ? ceil($total / $limit) : 0
            ]
        ];
    }

   
    public function listGastosByUsuario(string $usuario, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        $gastos = $this->gastoRepository->findByUsuario($usuario, $limit, $offset);
        $total = $this->gastoRepository->countByFilters($usuario);

        return [
            'gastos' => $gastos,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => ceil($total / $limit)
            ]
        ];
    }

    
    public function listGastosByFechaRange(string $fechaInicio, string $fechaFin, int $page = 1, int $limit = 20): array
    {
        $offset = ($page - 1) * $limit;
        $gastos = $this->gastoRepository->findByFechaRange($fechaInicio, $fechaFin, $limit, $offset);
        $total = $this->gastoRepository->countByFilters(null, null, $fechaInicio, $fechaFin);

        return [
            'gastos' => $gastos,
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => ceil($total / $limit)
            ]
        ];
    }

   
    public function getEstadisticas(array $filters = []): array
    {
        $usuario = $filters['usuario'] ?? null;
        $fechaInicio = $filters['fechaInicio'] ?? null;
        $fechaFin = $filters['fechaFin'] ?? null;

        return $this->gastoRepository->getEstadisticas($usuario, $fechaInicio, $fechaFin);
    }
}
?>