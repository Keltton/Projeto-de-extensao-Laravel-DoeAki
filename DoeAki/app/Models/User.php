<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'telefone',
        'cpf',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'sobre',
        'cadastro_completo',
        'role',
        'possui_empresa',
        'empresa_nome',
        'empresa_cnpj',
        'empresa_endereco'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'cadastro_completo' => 'boolean',
        'possui_empresa' => 'boolean'
    ];

    // RELACIONAMENTOS CORRIGIDOS

    /**
     * Doações do usuário
     */
    public function doacoes()
    {
        return $this->hasMany(Doacao::class);
    }

    /**
     * Eventos criados pelo usuário (se for admin)
     */
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'user_id');
    }

    /**
     * Inscrições do usuário em eventos (CORRIGIDO - usando tabela inscricoes)
     */
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }

    /**
     * Eventos que o usuário está inscrito (CORRIGIDO - usando tabela inscricoes)
     */
    public function eventosInscritos()
    {
        return $this->belongsToMany(Evento::class, 'inscricoes', 'user_id', 'evento_id')
                    ->withPivot('data_inscricao', 'status')
                    ->withTimestamps();
    }

    /**
     * Perfil do usuário
     */
    public function perfil()
    {
        return $this->hasOne(Perfil::class);
    }

    // MÉTODOS DE VERIFICAÇÃO

    /**
     * Verifica se o usuário é administrador
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Verifica se o usuário tem cadastro completo
     */
    public function hasCompleteProfile()
    {
        return $this->cadastro_completo;
    }

    /**
     * Verifica se o usuário está inscrito em um evento específico
     */
    public function estaInscritoNoEvento($eventoId)
    {
        return $this->inscricoes()
            ->where('evento_id', $eventoId)
            ->where('status', 'confirmada')
            ->exists();
    }

    /**
     * Conta o número de eventos que o usuário está inscrito
     */
    public function contarEventosInscritos()
    {
        return $this->inscricoes()
            ->where('status', 'confirmada')
            ->count();
    }
}