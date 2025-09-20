<?php

namespace App\Domain\Exception;

use Exception;

class GastoNotFoundException extends Exception
{
}
<?php

namespace App\Application\Service;

use App\Application\Port\In\GetGastoByIdUseCase;
use App\Application\Port\Out\GastoRepositoryPort;
use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;
use App\Domain\Exception\GastoNotFoundException;


class GetGastoByIdService implements GetGastoByIdUseCase
{
    private GastoRepositoryPort $gastoRepository;

    public function __construct(GastoRepositoryPort $gastoRepository)
    {
        $this->gastoRepository = $gastoRepository;
    }

    
    public function getGasto(GastoId $id): Gasto
    {
        $gasto = $this->gastoRepository->findById($id);

        if ($gasto === null) {
            throw new GastoNotFoundException("Gasto con ID {$id} no encontrado");
        }

        return $gasto;
    }

    
    public function getGastoByIdString(string $id): Gasto
    {
        $gastoId = GastoId::fromString($id);
        return $this->getGasto($gastoId);
    }

   
    public function exists(GastoId $id): bool
    {
        return $this->gastoRepository->exists($id);
    }
}
?>