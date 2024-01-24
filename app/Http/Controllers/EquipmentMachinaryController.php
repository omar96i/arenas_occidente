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

        $equipments_fuels = EquipmentMachinery::with(['fuelData' => function ($query) use ($month, $year) {
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

    public function getPerformance($month, $year){
        $equipments_performance = EquipmentMachinery::with([
            'fuelData' => function ($query) use ($month, $year) {
                $query->whereMonth('date', $month)->whereYear('date', $year);
            },
        ])->get()->toArray();

        foreach ($equipments_performance as &$equipment) {
            $given_fuel = EquipmentMachinery::givenFuel($equipment['id'], $month, $year);
            if ($given_fuel) {
                $equipment['fuel_data'][0]['gave'] = $given_fuel;
            }
        }
        
        return response()->json([
            'status' => true,
            'equipments_performance' => $equipments_performance
        ]);
    }
}
