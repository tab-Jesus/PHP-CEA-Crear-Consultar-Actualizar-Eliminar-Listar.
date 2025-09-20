<?php

namespace App\Application\Port\In;

use App\Domain\ValueObject\GastoId;


interface DeleteGastoUseCase
{
    /**
     *
     * @param GastoId $id 
     * @return bool 
     * @throws \DomainException 
     */
    public function deleteGasto(GastoId $id): bool;
}
?>