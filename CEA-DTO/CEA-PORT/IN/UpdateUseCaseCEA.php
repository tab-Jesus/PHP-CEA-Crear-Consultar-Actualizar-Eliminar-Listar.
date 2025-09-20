<?php

namespace App\Application\Port\In;

use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;


interface UpdateGastoUseCase
{
    /**
     *
     * @param GastoId $id 
     * @param array $gastoData 
     * @return Gasto 
     * @throws \DomainException 
     */
    public function updateGasto(GastoId $id, array $gastoData): Gasto;
}
?>