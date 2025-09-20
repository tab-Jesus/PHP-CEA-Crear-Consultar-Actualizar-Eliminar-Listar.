<?php
// src/Infrastructure/Adapters/Database/Eloquent/Model/GastoModel.php

namespace App\Infrastructure\Adapters\Database\Eloquent\Model;




class GastoModel 
{

    protected $table = 'gastos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'fecha',
        'valorTotalSinIVA',
        'ivaTotal',
        'valorTotalConIVA',
        'nombreUsuario',
        'lugar',
        'descripcion',
        'usuario_id',
        'procesado',
        'contabilizado'
    ];

    protected $casts = [
        'fecha' => 'date',
        'valorTotalSinIVA' => 'decimal:2',
        'ivaTotal' => 'decimal:2',
        'valorTotalConIVA' => 'decimal:2',
        'procesado' => 'boolean',
        'contabilizado' => 'boolean',
        'fecha_registro' => 'datetime'
    ];

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';


   

    public function scopeProcesado($query, $procesado = true)
    {
        return $query->where('procesado', $procesado);
    }

    public function scopeContabilizado($query, $contabilizado = true)
    {
        return $query->where('contabilizado', $contabilizado);
    }

  
    public function scopePorUsuario($query, $usuario)
    {
        return $query->where('nombreUsuario', 'LIKE', "%{$usuario}%");
    }

  
    public function scopePorLugar($query, $lugar)
    {
        return $query->where('lugar', 'LIKE', "%{$lugar}%");
    }

    public function scopePorRangoFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

 
    public function scopePorValorMinimo($query, $valorMinimo)
    {
        return $query->where('valorTotalConIVA', '>=', $valorMinimo);
    }

    
    public function scopePorValorMaximo($query, $valorMaximo)
    {
        return $query->where('valorTotalConIVA', '<=', $valorMaximo);
    }

    
    public function scopeOrdenarPorFechaDesc($query)
    {
        return $query->orderBy('fecha', 'desc')->orderBy('fecha_registro', 'desc');
    }

   


    
}
?>