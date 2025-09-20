<?php

namespace App\Infrastructure\Entrypoints\Rest\CEA\Request;



class UpdateCEAHttpRequest 
{
   
    public function authorize(): bool
    {
        return true;
    }

 
    public function rules(): array
    {
        return [
            'fecha' => 'sometimes|date|before_or_equal:today',
            'valor_total_sin_iva' => 'sometimes|numeric|min:0.01',
            'iva_total' => 'sometimes|numeric|min:0',
            'valor_total_con_iva' => 'sometimes|numeric|min:0.01',
            'lugar' => 'sometimes|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:50'
        ];
    }

  
    public function messages(): array
    {
        return [
            'fecha.date' => 'La fecha debe tener un formato válido',
            'fecha.before_or_equal' => 'La fecha no puede ser futura',
            
            'valor_total_sin_iva.numeric' => 'El valor sin IVA debe ser un número',
            'valor_total_sin_iva.min' => 'El valor sin IVA debe ser mayor a 0',
            
            'iva_total.numeric' => 'El IVA total debe ser un número',
            'iva_total.min' => 'El IVA total no puede ser negativo',
            
            'valor_total_con_iva.numeric' => 'El valor con IVA debe ser un número',
            'valor_total_con_iva.min' => 'El valor con IVA debe ser mayor a 0',
            
            'lugar.string' => 'El lugar debe ser texto',
            'lugar.max' => 'El lugar no puede exceder 100 caracteres',
            
            'descripcion.string' => 'La descripción debe ser texto',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres',
            
            'categoria.string' => 'La categoría debe ser texto',
            'categoria.max' => 'La categoría no puede exceder 50 caracteres'
        ];
    }


 

}






   
  