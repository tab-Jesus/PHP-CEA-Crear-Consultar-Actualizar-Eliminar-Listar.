<?php

namespace App\Infrastructure\Adapters\Database\Eloquent\Model;



class UserModel 
{


    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'activo'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
        'fecha_registro' => 'datetime'
    ];

    public $timestamps = true;
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

  
    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }

   
    public function scopePorEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'LIKE', "%{$nombre}%");
    }
}
?>