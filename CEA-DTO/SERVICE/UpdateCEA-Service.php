<?php

namespace App\Domain\Exception;

use RuntimeException;

class InvalidGastoStateException extends RuntimeException
{
}


namespace App\Application\Service;

use App\Application\Port\In\UpdateGastoUseCase;
use App\Application\Port\Out\GastoRepositoryPort;
use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;
use App\Domain\Exception\GastoNotFoundException;
use App\Domain\Exception\InvalidGastoStateException;


class UpdateGastoService implements UpdateGastoUseCase
{
    private GastoRepositoryPort $gastoRepository;

    public function __construct(GastoRepositoryPort $gastoRepository)
    {
        $this->gastoRepository = $gastoRepository;
    }

   
    public function updateGasto(GastoId $id, array $gastoData): Gasto
    {
        $gasto = $this->gastoRepository->findById($id);
        
        if ($gasto === null) {
            throw new GastoNotFoundException("Gasto con ID {$id} no encontrado");
        }

        $this->validateCanUpdate($gasto);

        $this->applyUpdates($gasto, $gastoData);

        $this->gastoRepository->save($gasto);

        return $gasto;
    }

   
    private function validateCanUpdate(Gasto $gasto): void
    {
        if ($gasto->isProcesado()) {
            throw new InvalidGastoStateException("No se puede modificar un gasto ya procesado");
        }

        if ($gasto->isContabilizado()) {
            throw new InvalidGastoStateException("No se puede modificar un gasto ya contabilizado");
        }
    }

    
    private function applyUpdates(Gasto $gasto, array $updates): void
    {
        if (isset($updates['fecha'])) {
            $gasto->setFecha(new \DateTime($updates['fecha']));
        }

        if (isset($updates['valorTotalSinIVA'])) {
            $gasto->setValorTotalSinIVA((float) $updates['valorTotalSinIVA']);
        }

        if (isset($updates['ivaTotal'])) {
            $gasto->setIvaTotal((float) $updates['ivaTotal']);
        }

        if (isset($updates['valorTotalConIVA'])) {
            $gasto->setValorTotalConIVA((float) $updates['valorTotalConIVA']);
        }

        if (isset($updates['lugar'])) {
            $gasto->setLugar($updates['lugar']);
        }

        if (isset($updates['descripcion'])) {
            $gasto->setDescripcion($updates['descripcion']);
        }

        if (isset($updates['nombreUsuario'])) {
            $gasto->setNombreUsuario($updates['nombreUsuario']);
        }
    }

   
    public function updateGastoByIdString(string $id, array $gastoData): Gasto
    {
        $gastoId = GastoId::fromString($id);
        return $this->updateGasto($gastoId, $gastoData);
    }
}
?>