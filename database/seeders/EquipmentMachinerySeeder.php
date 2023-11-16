<?php

namespace Database\Seeders;

use App\Models\EquipmentMachinery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentMachinerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // equipos
        EquipmentMachinery::insert([
            "name"=> 'MAHINDRA MUW566',
            "description"=> 'Carro de movilizacion de personal, supervisor',
            "register_number"=> '123',
            "file_img"=> '["qEsOG68wl6Yfmluqk11Nj4FoZYD5go-metaQ2FwdHVyYSBkZSBwYW50YWxsYSAyMDIzLTExLTE1IDE1MTc0Mi5wbmc=-.png"]',
            "status"=> 'operativo',
        ]);

        // valores de equipos maquinas categorias

        // valores de equipos maquinas opciones

    }
}
