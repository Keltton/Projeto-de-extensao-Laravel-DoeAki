<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_vencimento',
        'data_criacao',
        'img_path',
        'Id_tipo',
    ];


    public function tipoItem()
    {
        return $this->belongsTo(tipoItem::class, 'Id_tipo');
    }

}


