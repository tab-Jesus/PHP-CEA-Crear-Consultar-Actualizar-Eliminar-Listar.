<?php
// src/Infrastructure/Mapper/CEAMapper.php

namespace App\Infrastructure\Mapper;

use App\Domain\Entity\Gasto;
use App\Domain\ValueObject\GastoId;

class CEAMapper
{
   
    public static function toEntity(array $data): Gasto
    {
        return Gasto::reconstruir(
            $data['id'],
            new \DateTime($data['fecha']),
            (float) $data['valorTotalSinIVA'],
            (float) $data['ivaTotal'],
            (float) $data['valorTotalConIVA'],
            $data['nombreUsuario'],
            $data['lugar'],
            $data['descripcion'] ?? null,
            new \DateTime($data['fecha_registro']),
            (bool) $data['procesado'],
            (bool) $data['contabilizado']
        );
    }

 
    public static function toArray(Gasto $gasto): array
    {
        return [
            'id' => $gasto->getId()->toString(),
            'fecha' => $gasto->getFecha()->format('Y-m-d'),
            'valorTotalSinIVA' => $gasto->getValorTotalSinIVA(),
            'ivaTotal' => $gasto->getIvaTotal(),
            'valorTotalConIVA' => $gasto->getValorTotalConIVA(),
            'nombreUsuario' => $gasto->getNombreUsuario(),
            'lugar' => $gasto->getLugar(),
            'descripcion' => $gasto->getDescripcion(),
            'fecha_registro' => $gasto->getFechaRegistro()->format('Y-m-d H:i:s'),
            'procesado' => $gasto->isProcesado(),
            'contabilizado' => $gasto->isContabilizado()
        ];
    }

    
    public static function fromFormData(array $formData): array
    {
        return [
            'fecha' => $formData['fecha'] ?? date('Y-m-d'),
            'valorTotalSinIVA' => (float) ($formData['valorTotalSinIVA'] ?? 0),
            'ivaTotal' => (float) ($formData['ivaTotal'] ?? 0),
            'valorTotalConIVA' => (float) ($formData['valorTotalConIVA'] ?? 0),
            'nombreUsuario' => $formData['nombreUsuario'] ?? '',
            'lugar' => $formData['lugar'] ?? '',
            'descripcion' => $formData['descripcion'] ?? null
        ];
    }

   
    public static function fromUpdateFormData(array $formData): array
    {
        return [
            'fecha' => $formData['fecha'] ?? null,
            'valorTotalSinIVA' => isset($formData['valorTotalSinIVA']) ? (float) $formData['valorTotalSinIVA'] : null,
            'ivaTotal' => isset($formData['ivaTotal']) ? (float) $formData['ivaTotal'] : null,
            'valorTotalConIVA' => isset($formData['valorTotalConIVA']) ? (float) $formData['valorTotalConIVA'] : null,
            'lugar' => $formData['lugar'] ?? null,
            'descripcion' => $formData['descripcion'] ?? null
        ];
    }

   
    public static function fromDatabaseArray(array $dbData): Gasto
    {
        return self::toEntity([
            'id' => $dbData['id'],
            'fecha' => $dbData['fecha'],
            'valorTotalSinIVA' => $dbData['valorTotalSinIVA'],
            'ivaTotal' => $dbData['ivaTotal'],
            'valorTotalConIVA' => $dbData['valorTotalConIVA'],
            'nombreUsuario' => $dbData['nombreUsuario'],
            'lugar' => $dbData['lugar'],
            'descripcion' => $dbData['descripcion'],
            'fecha_registro' => $dbData['fecha_registro'],
            'procesado' => (bool) $dbData['procesado'],
            'contabilizado' => (bool) $dbData['contabilizado']
        ]);
    }

   
    public static function fromDatabaseArrayMultiple(array $dbDataArray): array
    {
        $gastos = [];
        foreach ($dbDataArray as $dbData) {
            $gastos[] = self::fromDatabaseArray($dbData);
        }
        return $gastos;
    }


    public static function validateCreateData(array $data): array
    {
        $errors = [];

        if (empty($data['fecha'])) {
            $errors[] = 'La fecha es obligatoria';
        } elseif (!strtotime($data['fecha'])) {
            $errors[] = 'La fecha tiene un formato inválido';
        }

        if (!isset($data['valorTotalSinIVA']) || $data['valorTotalSinIVA'] <= 0) {
            $errors[] = 'El valor sin IVA debe ser mayor a 0';
        }

        if (!isset($data['ivaTotal']) || $data['ivaTotal'] < 0) {
            $errors[] = 'El IVA no puede ser negativo';
        }

        if (!isset($data['valorTotalConIVA']) || $data['valorTotalConIVA'] <= 0) {
            $errors[] = 'El valor con IVA debe ser mayor a 0';
        }

        if (empty($data['nombreUsuario'])) {
            $errors[] = 'El nombre de usuario es obligatorio';
        }

        if (empty($data['lugar'])) {
            $errors[] = 'El lugar es obligatorio';
        }

        return $errors;
    }
}
?>