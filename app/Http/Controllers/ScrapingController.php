<?php

namespace App\Http\Controllers;

use Goutte\Client;
use Illuminate\Http\Request;

class ScrapingController extends Controller
{
    public function index()
    {
        // Obtener datos de los inputs
        $input1 = '2023-12-25';
        $input2 = '2024-03-24';
        $input3 = 'AUBNE';
        $input4 = 'BDCGP';

        // Crear una instancia de Goutte
        $client = new Client();

        // Hacer una solicitud y obtener el contenido de la página
        $crawler = $client->request('POST', 'https://www.wwalliance.com/wwaonline/sch/index.php', [
            'from_date' => $input1,
            'to_date' => $input2,
            'origins' => $input3,
            'destinationCodeHidden' => $input4,
        ]);

        // Extraer datos del HTML utilizando selectores CSS o XPath
        $scrapedData = $crawler->filter('#scheduleResultTable')->html();


        // Retornar los datos extraídos (por ejemplo, como respuesta JSON)
        return response()->json($scrapedData);
    }
}
