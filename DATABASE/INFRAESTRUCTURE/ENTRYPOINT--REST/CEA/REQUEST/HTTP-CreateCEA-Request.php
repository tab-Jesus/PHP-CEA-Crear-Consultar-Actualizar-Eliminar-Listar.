<?php

namespace App\Infrastructure\Entrypoints\Rest\CEA\Request;


class CreateCEAHttpRequest 
    {
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'fecha' => 'required|date|before_or_equal:today',
            'valor_total_sin_iva' => 'required|numeric|min:0.01',
            'iva_total' => 'required|numeric|min:0',
            'valor_total_con_iva' => 'required|numeric|min:0.01',
            'nombre_usuario' => 'required|string|max:100',
            'lugar' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:500',
            'categoria' => 'nullable|string|max:50'
        ];
    }
  
    public function messages(): array
    {
        return [
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date' => 'La fecha debe tener un formato válido',
            'fecha.before_or_equal' => 'La fecha no puede ser futura',
            
            'valor_total_sin_iva.required' => 'El valor sin IVA es obligatorio',
            'valor_total_sin_iva.numeric' => 'El valor sin IVA debe ser un número',
            'valor_total_sin_iva.min' => 'El valor sin IVA debe ser mayor a 0',
            
            'iva_total.required' => 'El IVA total es obligatorio',
            'iva_total.numeric' => 'El IVA total debe ser un número',
            'iva_total.min' => 'El IVA total no puede ser negativo',
            
            'valor_total_con_iva.required' => 'El valor con IVA es obligatorio',
            'valor_total_con_iva.numeric' => 'El valor con IVA debe ser un número',
            'valor_total_con_iva.min' => 'El valor con IVA debe ser mayor a 0',
            
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio',
            'nombre_usuario.string' => 'El nombre de usuario debe ser texto',
            'nombre_usuario.max' => 'El nombre de usuario no puede exceder 100 caracteres',
            
            'lugar.required' => 'El lugar es obligatorio',
            'lugar.string' => 'El lugar debe ser texto',
            'lugar.max' => 'El lugar no puede exceder 100 caracteres',
            
            'descripcion.string' => 'La descripción debe ser texto',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres',
            
            'categoria.string' => 'La categoría debe ser texto',
            'categoria.max' => 'La categoría no puede exceder 50 caracteres'
        ];
    }

    
 
   


    }

