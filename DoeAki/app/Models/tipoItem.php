<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipoNome',
    ];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'Id_tipo');
    }
}
