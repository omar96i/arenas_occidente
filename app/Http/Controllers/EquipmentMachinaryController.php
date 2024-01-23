<?php

namespace App\Http\Controllers;

use App\Models\EmFuelSources;
use App\Models\EquipmentMachinery;
use App\Models\EquipmentMachineryFuel;
use Illuminate\Http\Request;

class EquipmentMachinaryController extends Controller
{
    public function get(){
        return response()->json([
            'status' => true,
            'equipments' => EquipmentMachinery::with(['schedules' => function($query){
                $query->where('status', '!=', 'COMPLETO');
            }])->get()
        ]);
    }

    public function getFuels($month, $year){
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

        $equipments_fuels = EquipmentMachinery::with(['fuels' => function ($query) use ($month, $year) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }])->get()->toArray();

        foreach ($equipments_fuels as &$equipment) {
            $received = 0;

            foreach ($equipment['fuels'] as $fuels) {
                $received += $fuels['acpm'];
                if ($fuels['em_fuel_source_id']) {
                    $equipmentSource = EmFuelSources::find($fuels['em_fuel_source_id'])->equipment_machinery_id;
                    $foundIndex = array_search($equipmentSource, array_column($equipments_fuels, 'id'));

                    if ($foundIndex !== false) {
                        $foundObject = &$equipments_fuels[$foundIndex];

                        if (!isset($foundObject['gave'])) {
                            $foundObject['gave'] = 0;
                        }

                        $foundObject['gave'] += $fuels['acpm'];
                    }
                }
            }
            $equipment['received'] = $received;
        }

        return response()->json([
            'status' => true,
            'equipments_fuels' => $equipments_fuels
        ]);
    }
}
