
<?php
// src/Application/Port/In/GetGastoByIdUseCase.php

namespace App\Application\Port\In;

use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;

/**
 * GetGastoByIdUseCase: Caso de uso para obtener un gasto por su ID
 */
interface GetGastoByIdUseCase
{
    /**
     * Obtener un gasto por su ID
     *
     * @param GastoId $id ID del gasto a obtener
     * @return Gasto El gasto encontrado
     * @throws \DomainException Si el gasto no existe
     */
    public function getGasto(GastoId $id): Gasto;
}
?>