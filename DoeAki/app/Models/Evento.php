<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'data_evento',
        'local',
        'endereco',
        'cidade',
        'estado',
        'cep',
        'vagas_total',
        'vagas_disponiveis',
        'status',
        'imagem'
    ];

    protected $casts = [
        'data_evento' => 'datetime',
    ];

    protected $appends = [
        'status_portugues',
        'data_formatada',
        'inscricoes_count',
        'tem_vagas'
    ];

    /**
     * Usuário que criou o evento
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Inscrições no evento
     */
    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class);
    }

    /**
     * Usuários inscritos no evento
     */
    public function usuariosInscritos()
    {
        return $this->belongsToMany(User::class, 'inscricoes', 'evento_id', 'user_id')
                    ->withTimestamps()
                    ->withPivot(['data_inscricao', 'status']);
    }

    /**
     * Acessor para status em português
     */
    public function getStatusPortuguesAttribute()
    {
        $statusMap = [
            'ativo' => 'Ativo',
            'inativo' => 'Inativo',
            'cancelado' => 'Cancelado'
        ];

        return $statusMap[$this->status] ?? $this->status;
    }

    /**
     * Acessor para data formatada
     */
    public function getDataFormatadaAttribute()
    {
        return $this->data_evento->format('d/m/Y H:i');
    }

    /**
     * Acessor para contagem de inscrições
     */
    public function getInscricoesCountAttribute()
    {
        return $this->inscricoes()->count();
    }

    /**
     * Verificar se há vagas disponíveis
     */
    public function getTemVagasAttribute()
    {
        if ($this->vagas_disponiveis === null) {
            return true; // Sem limite de vagas
        }

        return $this->vagas_disponiveis > 0;
    }

    /**
     * Scope para eventos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('status', 'ativo');
    }

    /**
     * Scope para eventos futuros
     */
    public function scopeFuturos($query)
    {
        return $query->where('data_evento', '>=', now());
    }

    /**
     * Scope para buscar por termo
     */
    public function scopeBuscar($query, $termo)
    {
        return $query->where(function($q) use ($termo) {
            $q->where('nome', 'like', '%' . $termo . '%')
              ->orWhere('descricao', 'like', '%' . $termo . '%')
              ->orWhere('local', 'like', '%' . $termo . '%');
        });
    }
}