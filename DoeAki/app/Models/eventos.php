<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'data_vencimento',
        'data_criacao',
        'img_path',
        'tipo_id',
    ];


    public function tipoItem()
    {
        return $this->belongsTo(tipoItem::class, 'tipo_id');
    }

}


