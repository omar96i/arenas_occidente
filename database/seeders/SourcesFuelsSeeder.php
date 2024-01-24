<?php

namespace Database\Seeders;

use App\Models\FuelControlSource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourcesFuelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // insertar estas fuentes de combustible
        $sources = [
            'CARROTANQUE SOB792',
            'CARROTANQUE WMB462',
            'EDS ANTIOQUEÑA',
            'ESTACION TERPEL PUERTA DEL SUR CANDELARIA',
            'INGENIO',
            'PORRONES MAYAGUEZ',
            'TANQUE SAN CARLOS',
            'RIO PAILA',
            'EDS ZEUS',
            'ESTACION BRIO CANDELARIA EL ARENAL',
            'ESTACION EL FARO DE GUACARI',
            'ESTACION ESTRELLA DEL NORTE',
            'ESTACION ROSA LA TUPIA',
            'ESTACION SAN ANTONIO',
            'ESTACION BIOMAX CANDELARIA',
            'ESTACION AMERICAS YUMBO',
            'TEXACO ARROYOHONDO',
            'CARRETERA',
            'EDS BRIO LA COLOMBIANA CANDELARIA',
            'EDS EL PALMAR',
            'GIRALDO-ANTIOQUIA',
            'CANECAS ITALCOL',
        ];

        foreach ($sources as $name) {
            FuelControlSource::create([
                'name' => $name,
            ]);
        }
    }
}
