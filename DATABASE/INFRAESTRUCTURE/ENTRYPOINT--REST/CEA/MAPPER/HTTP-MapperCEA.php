<?php

namespace App\Infrastructure\Entrypoints\Rest\CEA\Mapper;

use App\Domain\Entity\Gasto;


class CEAHttpMapper
{
 
    public static function mapRequestToGastoData(array $requestData): array
    {
        return [
            'fecha' => $requestData['fecha'] ?? date('Y-m-d'),
            'valorTotalSinIVA' => (float) ($requestData['valor_total_sin_iva'] ?? 0),
            'ivaTotal' => (float) ($requestData['iva_total'] ?? 0),
            'valorTotalConIVA' => (float) ($requestData['valor_total_con_iva'] ?? 0),
            'nombreUsuario' => $requestData['nombre_usuario'] ?? '',
            'lugar' => $requestData['lugar'] ?? '',
            'descripcion' => $requestData['descripcion'] ?? null,
            'categoria' => $requestData['categoria'] ?? 'general'
        ];
    }

   
    public static function mapGastoToArray(Gasto $gasto): array
    {
        return [
            'id' => $gasto->getId()->toString(),
            'fecha' => $gasto->getFecha()->format('Y-m-d'),
            'valor_total_sin_iva' => $gasto->getValorTotalSinIVA(),
            'iva_total' => $gasto->getIvaTotal(),
            'valor_total_con_iva' => $gasto->getValorTotalConIVA(),
            'nombre_usuario' => $gasto->getNombreUsuario(),
            'lugar' => $gasto->getLugar(),
            'descripcion' => $gasto->getDescripcion(),
            'procesado' => $gasto->isProcesado(),
            'contabilizado' => $gasto->isContabilizado(),
            'fecha_registro' => $gasto->getFechaRegistro()->format('Y-m-d H:i:s'),
        ];
    }

 
    public static function mapFilters(array $requestFilters): array
    {
        return [
            'usuario' => $requestFilters['usuario'] ?? null,
            'lugar' => $requestFilters['lugar'] ?? null,
            'fechaInicio' => $requestFilters['fecha_inicio'] ?? null,
            'fechaFin' => $requestFilters['fecha_fin'] ?? null,
            'valorMinimo' => isset($requestFilters['valor_minimo']) ? (float) $requestFilters['valor_minimo'] : null,
            'valorMaximo' => isset($requestFilters['valor_maximo']) ? (float) $requestFilters['valor_maximo'] : null,
            'categoria' => $requestFilters['categoria'] ?? null
        ];
    }

  
    public static function validateCreateData(array $data): array
    {
        $errors = [];

        if (empty($data['fecha'])) {
            $errors[] = 'La fecha es requerida';
        } elseif (!strtotime($data['fecha'])) {
            $errors[] = 'La fecha tiene un formato inválido';
        }

        if (!isset($data['valor_total_sin_iva']) || $data['valor_total_sin_iva'] <= 0) {
            $errors[] = 'El valor sin IVA debe ser mayor a 0';
        }

        if (!isset($data['iva_total']) || $data['iva_total'] < 0) {
            $errors[] = 'El IVA no puede ser negativo';
        }

        if (!isset($data['valor_total_con_iva']) || $data['valor_total_con_iva'] <= 0) {
            $errors[] = 'El valor con IVA debe ser mayor a 0';
        }

        if (empty($data['nombre_usuario'])) {
            $errors[] = 'El nombre de usuario es requerido';
        }

        if (empty($data['lugar'])) {
            $errors[] = 'El lugar es requerido';
        }

        return $errors;
    }

    
    public static function validateUpdateData(array $data): array
    {
        $errors = [];

        if (isset($data['fecha']) && !strtotime($data['fecha'])) {
            $errors[] = 'La fecha tiene un formato inválido';
        }

        if (isset($data['valor_total_sin_iva']) && $data['valor_total_sin_iva'] <= 0) {
            $errors[] = 'El valor sin IVA debe ser mayor a 0';
        }

        if (isset($data['iva_total']) && $data['iva_total'] < 0) {
            $errors[] = 'El IVA no puede ser negativo';
        }

        if (isset($data['valor_total_con_iva']) && $data['valor_total_con_iva'] <= 0) {
            $errors[] = 'El valor con IVA debe ser mayor a 0';
        }

        if (isset($data['lugar']) && empty($data['lugar'])) {
            $errors[] = 'El lugar no puede estar vacío';
        }

        return $errors;
    }

   
    public static function formatErrors(array $errors): array
    {
        return [
            'error' => 'Error de validación',
            'messages' => $errors,
            'code' => 'validation_error'
        ];
    }
}
?>