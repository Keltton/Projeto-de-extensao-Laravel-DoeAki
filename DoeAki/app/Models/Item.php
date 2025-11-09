<?php
// app/Models/Item.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'itens'; // Tabela já existe

    protected $fillable = ['nome', 'descricao', 'categoria_id', 'ativo'];

    protected $casts = ['ativo' => 'boolean'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function doacoes()
    {
        return $this->hasMany(Doacao::class);
    }

}