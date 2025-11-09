<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        $eventos = [
            [
                'nome' => 'Campanha do Agasalho 2024',
                'descricao' => 'Arrecadação de roupas de frio para comunidades carentes',
                'data_evento' => Carbon::now()->addDays(15),
                'local' => 'Praça Central',
                'endereco' => 'Rua Principal, 123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
                'cep' => '01234-567',
                'status' => 'ativo'
            ],
            [
                'nome' => 'Feira de Doações Infantis',
                'descricao' => 'Arrecadação de brinquedos, roupas e material escolar para crianças',
                'data_evento' => Carbon::now()->addDays(30),
                'local' => 'Ginásio Municipal',
                'endereco' => 'Av. das Flores, 456',
                'cidade' => 'Rio de Janeiro',
                'estado' => 'RJ',
                'cep' => '22345-678',
                'status' => 'ativo'
            ],
            [
                'nome' => 'Doação de Alimentos - Comunidade Local',
                'descricao' => 'Campanha de arrecadação de alimentos não perecíveis',
                'data_evento' => Carbon::now()->addDays(7),
                'local' => 'Igreja São Francisco',
                'endereco' => 'Praça da Matriz, 789',
                'cidade' => 'Belo Horizonte',
                'estado' => 'MG',
                'cep' => '30123-456',
                'status' => 'ativo'
            ],
            [
                'nome' => 'Evento de Doação de Móveis',
                'descricao' => 'Recebemos móveis usados em bom estado para famílias necessitadas',
                'data_evento' => Carbon::now()->addDays(45),
                'local' => 'Galpão de Doações',
                'endereco' => 'Rua Industrial, 321',
                'cidade' => 'Porto Alegre',
                'estado' => 'RS',
                'cep' => '90123-456',
                'status' => 'ativo'
            ],
            [
                'nome' => 'Campanha de Higiene Pessoal',
                'descricao' => 'Arrecadação de produtos de higiene para abrigos',
                'data_evento' => Carbon::now()->addDays(20),
                'local' => 'Centro Comunitário',
                'endereco' => 'Av. Central, 654',
                'cidade' => 'Salvador',
                'estado' => 'BA',
                'cep' => '40123-456',
                'status' => 'inativo'
            ]
        ];

        foreach ($eventos as $evento) {
            Evento::create(array_merge($evento, [
                'user_id' => $users->random()->id
            ]));
        }
    }
}