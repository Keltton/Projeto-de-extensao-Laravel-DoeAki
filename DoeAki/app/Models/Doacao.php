<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'doacoes';

    protected $fillable = [
        'user_id',
        'item_id',
        'quantidade',
        'condicao',
        'descricao',
        'status',
        'data_doacao',
        'data_aprovacao',
        'data_rejeicao',
        'data_entrega',
        'data_entrada_estoque',
        'motivo_rejeicao',
        'adicionado_estoque',
        'aprovado_por'
    ];

    protected $casts = [
        'data_doacao' => 'datetime',
        'data_aprovacao' => 'datetime',
        'data_rejeicao' => 'datetime',
        'data_entrega' => 'datetime',
        'data_entrada_estoque' => 'datetime',
        'quantidade' => 'integer',
        'adicionado_estoque' => 'boolean'
    ];

    // Definição das condições possíveis
    const CONDICOES = [
        'novo' => 'Novo (selado/ nunca usado)',
        'seminovo' => 'Seminovo (pouco uso)',
        'usado' => 'Usado (em bom estado)',
        'precisa_reparo' => 'Precisa de reparos'
    ];

    // Definição dos status possíveis (ATUALIZADO)
    const STATUS = [
        'pendente' => 'Pendente',
        'aceita' => 'Aceita',
        'rejeitada' => 'Rejeitada',
        'entregue' => 'Entregue' // NOVO STATUS
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function aprovador()
    {
        return $this->belongsTo(User::class, 'aprovado_por');
    }

    /**
     * Acessor para obter a label da condição
     */
    public function getCondicaoLabelAttribute()
    {
        return self::CONDICOES[$this->condicao] ?? $this->condicao;
    }

    /**
     * Acessor para obter a cor da condição
     */
    public function getCondicaoColorAttribute()
    {
        $colors = [
            'novo' => 'success',
            'seminovo' => 'info', 
            'usado' => 'warning',
            'precisa_reparo' => 'danger'
        ];

        return $colors[$this->condicao] ?? 'secondary';
    }

    /**
     * Acessor para obter a label do status
     */
    public function getStatusLabelAttribute()
    {
        return self::STATUS[$this->status] ?? $this->status;
    }

    /**
     * Acessor para obter a cor do status
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pendente' => 'warning',
            'aceita' => 'success',
            'rejeitada' => 'danger',
            'entregue' => 'info' // NOVA COR
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Scope para doações pendentes
     */
    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    /**
     * Scope para doações aprovadas
     */
    public function scopeAprovadas($query)
    {
        return $query->where('status', 'aceita');
    }

    /**
     * Scope para doações entregues
     */
    public function scopeEntregues($query)
    {
        return $query->where('status', 'entregue');
    }

    /**
     * Scope para doações no estoque
     */
    public function scopeNoEstoque($query)
    {
        return $query->where('adicionado_estoque', true);
    }

    /**
     * Método para aprovar doação e adicionar ao estoque
     */
    public function aprovar($aprovadorId)
    {
        return $this->update([
            'status' => 'aceita',
            'adicionado_estoque' => true,
            'data_aprovacao' => now(),
            'data_entrada_estoque' => now(),
            'aprovado_por' => $aprovadorId
        ]);
    }

    /**
     * Método para rejeitar doação
     */
    public function rejeitar($motivo)
    {
        return $this->update([
            'status' => 'rejeitada',
            'motivo_rejeicao' => $motivo,
            'data_rejeicao' => now(),
            'adicionado_estoque' => false
        ]);
    }

    /**
     * Método para marcar como entregue
     */
    public function marcarEntregue()
    {
        return $this->update([
            'status' => 'entregue',
            'data_entrega' => now()
        ]);
    }
}