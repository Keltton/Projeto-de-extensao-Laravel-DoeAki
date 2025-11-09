<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        // Primeiro, verificar se existem categorias
        $categoriasCount = DB::table('categorias')->count();
        
        if ($categoriasCount === 0) {
            $this->command->error('Não há categorias disponíveis. Execute CategoriaSeeder primeiro.');
            return;
        }

        $itens = [
            [
                'nome' => 'Camiseta Masculina M',
                'descricao' => 'Camiseta em bom estado, cor azul',
                'categoria_id' => 1 // Roupas
            ],
            [
                'nome' => 'Tênis Nike 42',
                'descricao' => 'Tênis esportivo pouco usado',
                'categoria_id' => 2 // Calçados
            ],
            [
                'nome' => 'Smartphone Samsung',
                'descricao' => 'Smartphone funcionando perfeitamente',
                'categoria_id' => 3 // Eletrônicos
            ],
            [
                'nome' => 'Sofá 3 lugares',
                'descricao' => 'Sofá em bom estado de conservação',
                'categoria_id' => 4 // Móveis
            ],
            [
                'nome' => 'Livro - Dom Casmurro',
                'descricao' => 'Livro de Machado de Assis, edição 2010',
                'categoria_id' => 5 // Livros
            ],
            [
                'nome' => 'Boneca Barbie',
                'descricao' => 'Boneca em bom estado, completa',
                'categoria_id' => 6 // Brinquedos
            ],
            [
                'nome' => 'Arroz 5kg',
                'descricao' => 'Pacote de arroz fechado',
                'categoria_id' => 7 // Alimentos
            ],
            [
                'nome' => 'Kit Higiene Pessoal',
                'descricao' => 'Sabonete, shampoo e creme dental',
                'categoria_id' => 8 // Higiene Pessoal
            ],
            [
                'nome' => 'Panela de Pressão',
                'descricao' => 'Panela de pressão 5L, pouco usada',
                'categoria_id' => 9 // Utensílios Domésticos
            ],
            [
                'nome' => 'Cobertor Casal',
                'descricao' => 'Cobertor de lã, limpo e em bom estado',
                'categoria_id' => 10 // Outros
            ]
        ];

        foreach ($itens as $item) {
            // Verificar se a categoria existe
            $categoriaExists = DB::table('categorias')->where('id', $item['categoria_id'])->exists();
            
            if (!$categoriaExists) {
                $this->command->warn("Categoria ID {$item['categoria_id']} não existe para o item: {$item['nome']}");
                continue;
            }

            try {
                DB::table('itens')->insert([
                    'nome' => $item['nome'],
                    'descricao' => $item['descricao'],
                    'categoria_id' => $item['categoria_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->command->info("✅ Item '{$item['nome']}' criado com sucesso!");
            } catch (\Exception $e) {
                $this->command->error("❌ Erro ao criar item '{$item['nome']}': " . $e->getMessage());
            }
        }

        $this->command->info('🎉 Processo de criação de itens finalizado!');
    }
}