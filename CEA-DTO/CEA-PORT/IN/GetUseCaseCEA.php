
<?php

namespace App\Application\Port\In;

use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;


interface GetGastoByIdUseCase
{
    /**
     *
     * @param GastoId $id 
     * @return Gasto 
     * @throws \DomainException 
     */
    public function getGasto(GastoId $id): Gasto;
}
?>