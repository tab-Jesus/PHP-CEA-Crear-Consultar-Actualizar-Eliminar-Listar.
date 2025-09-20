<?php

namespace App\Application\Port\In;

use App\Domain\Entity\Gasto;


interface CreateGastoUseCase
{
    /**
     * 
     *
     * @param array $gastoData 
     * @return Gasto 
     * @throws \InvalidArgumentException 
     * @throws \DomainException 
     */
    public function createGasto(array $gastoData): Gasto;
}
?>