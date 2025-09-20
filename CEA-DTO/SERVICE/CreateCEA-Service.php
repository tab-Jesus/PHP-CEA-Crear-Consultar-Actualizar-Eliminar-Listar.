<?php

namespace App\Application\Service;

use App\Application\Port\In\CreateGastoUseCase;
use App\Application\Port\Out\GastoRepositoryPort;
use App\Domain\Entity\Gasto;
use App\Infrastructure\Mapper\GastoMapper;


class CreateGastoService implements CreateGastoUseCase
{
    private GastoRepositoryPort $gastoRepository;

    public function __construct(GastoRepositoryPort $gastoRepository)
    {
        $this->gastoRepository = $gastoRepository;
    }

  
    public function createGasto(array $gastoData): Gasto
    {
        $this->validateGastoData($gastoData);

        $gasto = GastoMapper::fromArray($gastoData);

        $this->gastoRepository->save($gasto);

        return $gasto;
    }

   
    private function validateGastoData(array $data): void
    {
        $requiredFields = ['fecha', 'valorTotalSinIVA', 'ivaTotal', 'valorTotalConIVA', 'nombreUsuario', 'lugar'];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                throw new \InvalidArgumentException("El campo {$field} es requerido");
            }
        }

        if ($data['valorTotalSinIVA'] <= 0) {
            throw new \InvalidArgumentException("El valor sin IVA debe ser mayor a 0");
        }

        if ($data['ivaTotal'] < 0) {
            throw new \InvalidArgumentException("El IVA no puede ser negativo");
        }

        if ($data['valorTotalConIVA'] <= 0) {
            throw new \InvalidArgumentException("El valor con IVA debe ser mayor a 0");
        }

        if (!strtotime($data['fecha'])) {
            throw new \InvalidArgumentException("La fecha tiene un formato inválido");
        }

        $calculatedTotal = $data['valorTotalSinIVA'] + $data['ivaTotal'];
        if (abs($calculatedTotal - $data['valorTotalConIVA']) > 0.01) {
            throw new \InvalidArgumentException(
                "El valor total con IVA no coincide con la suma del valor sin IVA y el IVA"
            );
        }
    }
}
?>