<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->count() === 0) {
            $this->command->error('❌ Nenhum usuário encontrado. Execute o AdminSeeder primeiro.');
            return;
        }

        $eventos = [
            [
                'nome' => 'Campanha do Agasalho 2024',
                'descricao' => 'Arrecadação de roupas de frio para comunidades carentes.',
                'data_evento' => Carbon::now()->addDays(15),
                'local' => 'Praça Central',
                'endereco' => 'Rua Principal, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento1.jpg' // ← CORRIGIDO: images/eventos/
            ],
            [
                'nome' => 'Feira de Doações Infantis',
                'descricao' => 'Arrecadação de brinquedos, roupas e material escolar para crianças.',
                'data_evento' => Carbon::now()->addDays(30),
                'local' => 'Ginásio Municipal',
                'endereco' => 'Av. das Flores, 456',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'cep' => '22345-678',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento2.jpg' // ← CORRIGIDO: images/eventos/
            ],
            [
                'nome' => 'Doação de Alimentos - Comunidade Local',
                'descricao' => 'Campanha de arrecadação de alimentos não perecíveis para famílias em situação de vulnerabilidade.',
                'data_evento' => Carbon::now()->addDays(7),
                'local' => 'Igreja São Francisco',
                'endereco' => 'Praça da Matriz, 789',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'cep' => '30123-456',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento3.jpg' // ← CORRIGIDO: images/eventos/
            ],
            [
                'nome' => 'Evento de Doação de Móveis',
                'descricao' => 'Recebimento de móveis usados em bom estado para famílias carentes.',
                'data_evento' => Carbon::now()->addDays(45),
                'local' => 'Galpão de Doações',
                'endereco' => 'Rua Industrial, 321',
                'cidade' => 'Porto Alegre',
                'estado' => 'RS',
                'cep' => '90123-456',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento4.jpg' // ← CORRIGIDO: images/eventos/
            ],
            [
                'nome' => 'Campanha de Higiene Pessoal',
                'descricao' => 'Coleta de produtos de higiene e limpeza para abrigos e instituições.',
                'data_evento' => Carbon::now()->addDays(20),
                'local' => 'Centro Comunitário',
                'endereco' => 'Av. Central, 654',
                'cidade' => 'Salvador',
                'estado' => 'BA',
                'cep' => '40123-456',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento5.jpg' // ← CORRIGIDO: images/eventos/
            ],
            [
                'nome' => 'Natal Solidário 2024',
                'descricao' => 'Entrega de cestas básicas e brinquedos para famílias durante o Natal.',
                'data_evento' => Carbon::now()->addDays(60),
                'local' => 'Paróquia Santa Luzia',
                'endereco' => 'Rua do Sol, 200',
                'cidade' => 'Fortaleza',
                'estado' => 'CE',
                'cep' => '60123-789',
                'status' => 'ativo',
                'imagem' => 'images/eventos/evento6.jpg' // ← CORRIGIDO: images/eventos/
            ]
        ];

        foreach ($eventos as $evento) {
            Evento::create(array_merge($evento, [
                'user_id' => $users->random()->id
            ]));
        }

        $this->command->info('✅ 10 eventos criados com sucesso!');
    }
}