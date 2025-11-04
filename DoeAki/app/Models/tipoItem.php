<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_nome',
    ];

    public function eventos()
    {
        return $this->hasMany(eventos::class, 'tipo_id');
    }
}
