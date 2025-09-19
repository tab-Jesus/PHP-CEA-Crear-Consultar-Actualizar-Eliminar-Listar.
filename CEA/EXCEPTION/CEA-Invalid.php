<?php

namespace App\Domain\Exception;


class InvalidGastoState extends \DomainException
{
    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

 
    public static function cannotModifyProcessedGasto(string $gastoId): self
    {
        return new self(
            sprintf('No se puede modificar el gasto con ID %s porque ya ha sido procesado.', $gastoId)
        );
    }

  
    public static function cannotDeleteAccountedGasto(string $gastoId): self
    {
        return new self(
            sprintf('No se puede eliminar el gasto con ID %s porque ya ha sido contabilizado.', $gastoId)
        );
    }

   
    public static function invalidValue(float $value): self
    {
        return new self(
            sprintf('El valor del gasto (%s) no puede ser negativo o cero.', $value)
        );
    }

  
    public static function invalidDate(string $date): self
    {
        return new self(
            sprintf('La fecha del gasto (%s) no puede ser futura.', $date)
        );
    }
}
?>