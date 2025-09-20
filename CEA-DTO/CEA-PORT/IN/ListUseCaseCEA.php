<?php

namespace App\Application\Port\In;


interface ListGastosUseCase
{
    
    /**
     * @param array $filters
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function listGastos(array $filters = [], int $page = 1, int $limit = 20): array;
}
?>