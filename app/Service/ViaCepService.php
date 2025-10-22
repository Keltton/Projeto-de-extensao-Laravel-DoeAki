<?php

namespace App\Services;

class ViaCepService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://viacep.com.br/ws';
    }

    public function getEndereco(string $cep): array
    {
        $cep = preg_replace('/[^0-9]/', '', $cep);

        if (strlen($cep) !== 8) {
            return ['erro' => true, 'mensagem' => 'CEP inválido.'];
        }

        $url = "{$this->baseUrl}/{$cep}/json/";

        $curl = curl_init($url);
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: PHP-Cep-App'
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if (!$response) {
            return ['erro' => true, 'mensagem' => 'Erro ao consultar a API'];
        }

        $data = json_decode($response, true);

        if (isset($data['erro']) && $data['erro'] === true) {
            return ['erro' => true, 'mensagem' => 'CEP não encontrado'];
        }

        return $data;
    }
}
