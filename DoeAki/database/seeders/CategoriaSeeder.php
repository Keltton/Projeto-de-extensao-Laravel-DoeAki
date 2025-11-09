<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Roupas',
                'descricao' => 'Roupas em geral para doação'
            ],
            [
                'nome' => 'Calçados',
                'descricao' => 'Sapatos, tênis e outros calçados'
            ],
            [
                'nome' => 'Eletrônicos',
                'descricao' => 'Aparelhos eletrônicos e eletrodomésticos'
            ],
            [
                'nome' => 'Móveis',
                'descricao' => 'Móveis usados em bom estado'
            ],
            [
                'nome' => 'Livros',
                'descricao' => 'Livros e material didático'
            ],
            [
                'nome' => 'Brinquedos',
                'descricao' => 'Brinquedos para crianças'
            ],
            [
                'nome' => 'Alimentos',
                'descricao' => 'Alimentos não perecíveis'
            ],
            [
                'nome' => 'Higiene Pessoal',
                'descricao' => 'Produtos de higiene e limpeza'
            ],
            [
                'nome' => 'Utensílios Domésticos',
                'descricao' => 'Utensílios para casa'
            ],
            [
                'nome' => 'Outros',
                'descricao' => 'Outros itens para doação'
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}