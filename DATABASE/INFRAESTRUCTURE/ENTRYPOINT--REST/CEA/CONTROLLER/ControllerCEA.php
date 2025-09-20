<?php

namespace App\Infrastructure\Entrypoints\Rest\CEA\Controller;

use App\Application\Port\In\CreateGastoUseCase;
use App\Application\Port\In\GetGastoByIdUseCase;
use App\Application\Port\In\ListGastosUseCase;
use App\Application\Port\In\UpdateGastoUseCase;
use App\Application\Port\In\DeleteGastoUseCase;


class CEAController
{
    public function __construct(
        private CreateGastoUseCase $createGastoUseCase,
        private GetGastoByIdUseCase $getGastoByIdUseCase,
        private ListGastosUseCase $listGastosUseCase,
        private UpdateGastoUseCase $updateGastoUseCase,
        private DeleteGastoUseCase $deleteGastoUseCase
    ) {}

    }



    