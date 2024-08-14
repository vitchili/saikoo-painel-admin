<?php

namespace App\Gateway;

use GuzzleHttp\Client;

class ConsultaIndicesIGPM 
{
    public const URL_API_CONSULTA_IGPM = 'https://api.bcb.gov.br/dados/serie/bcdata.sgs.4175/dados?formato=json';

    public Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function consultarHistoricoIndicesIGPM(): array
    {
        $consulta = $this->client->get(self::URL_API_CONSULTA_IGPM);
        
        $response = $consulta->getBody();
        
        return json_decode($response, true);
    }
}