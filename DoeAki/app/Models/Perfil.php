<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    use HasFactory;

    protected $table = 'perfis';

    protected $fillable = [
        'user_id',
        'telefone',
        'data_nascimento',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'possui_empresa',
        'razao_social',
        'cnpj',
        'inscricao_estadual',
        'endereco_empresa',
        'telefone_empresa'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'possui_empresa' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}