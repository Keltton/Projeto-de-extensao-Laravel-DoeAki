<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

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
        'aprovado_por',
        'entregue' // ADICIONADO
    ];

    protected $casts = [
        'data_doacao' => 'datetime',
        'data_aprovacao' => 'datetime',
        'data_rejeicao' => 'datetime',
        'data_entrega' => 'datetime',
        'data_entrada_estoque' => 'datetime',
        'quantidade' => 'integer',
        'adicionado_estoque' => 'boolean',
        'entregue' => 'boolean' // ADICIONADO
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
        'aprovado' => 'Aprovado', // ADICIONADO para compatibilidade
        'rejeitada' => 'Rejeitada',
        'rejeitado' => 'Rejeitado', // ADICIONADO para compatibilidade
        'entregue' => 'Entregue'
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
    // Acessor para obter a label do status
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pendente' => 'Pendente',
            'aceita' => 'Aceita',
            'rejeitada' => 'Rejeitada',
            'entregue' => 'Entregue',
            default => ucfirst($this->status)
        };
    }

    // Acessor para obter a cor do status
    public function getStatusColorAttribute()
    {
        $colors = [
            'pendente' => 'warning',
            'aceita' => 'success',
            'rejeitada' => 'danger',
            'entregue' => 'info'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Verifica se a doação pode ser marcada como entregue
     */
    public function getPodeSerEntregueAttribute()
    {
        return in_array($this->status, ['aceita', 'aprovado']) && $this->status !== 'entregue';
    }

    /**
     * Verifica se a doação está pendente
     */
    public function getEstaPendenteAttribute()
    {
        return $this->status === 'pendente';
    }

    /**
     * Verifica se a doação foi aprovada
     */
    public function getFoiAprovadaAttribute()
    {
        return in_array($this->status, ['aceita', 'aprovado']);
    }

    /**
     * Verifica se a doação foi rejeitada
     */
    public function getFoiRejeitadaAttribute()
    {
        return in_array($this->status, ['rejeitada', 'rejeitado']);
    }

    /**
     * Verifica se a doação foi entregue
     */
    public function getFoiEntregueAttribute()
    {
        return $this->status === 'entregue';
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
        return $query->whereIn('status', ['aceita', 'aprovado']);
    }

    /**
     * Scope para doações rejeitadas
     */
    public function scopeRejeitadas($query)
    {
        return $query->whereIn('status', ['rejeitada', 'rejeitado']);
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
     * Scope para doações que podem ser entregues
     */
    public function scopeParaEntrega($query)
    {
        return $query->whereIn('status', ['aceita', 'aprovado'])
            ->where('status', '!=', 'entregue');
    }

    /**
     * Método para aprovar doação e adicionar ao estoque
     */
    public function aprovar($aprovadorId = null)
    {
        $updateData = [
            'status' => 'aceita', // Usar 'aceita' que é mais curto e compatível
            'adicionado_estoque' => true,
            'data_aprovacao' => now(),
            'data_entrada_estoque' => now(),
        ];

        if ($aprovadorId) {
            $updateData['aprovado_por'] = $aprovadorId;
        } elseif (auth()->check()) {
            $updateData['aprovado_por'] = auth()->id();
        }

        return $this->update($updateData);
    }

    /**
     * Método para rejeitar doação
     */
    public function rejeitar($motivo = null)
    {
        $updateData = [
            'status' => 'rejeitada', // Usar 'rejeitada' que é mais curto
            'data_rejeicao' => now(),
            'adicionado_estoque' => false
        ];

        if ($motivo) {
            $updateData['motivo_rejeicao'] = $motivo;
        }

        return $this->update($updateData);
    }

    /**
     * Método para marcar como entregue
     */
    public function marcarEntregue()
    {
        $updateData = [
            'status' => 'entregue',
            'data_entrega' => now()
        ];

        // Se a coluna entregue existe, atualiza também
        if (Schema::hasColumn('doacoes', 'entregue')) {
            $updateData['entregue'] = true;
        }

        return $this->update($updateData);
    }

    /**
     * Boot do model
     */
    protected static function boot()
    {
        parent::boot();

        // Definir data_doacao automaticamente ao criar
        static::creating(function ($doacao) {
            if (empty($doacao->data_doacao)) {
                $doacao->data_doacao = now();
            }
        });
    }
}