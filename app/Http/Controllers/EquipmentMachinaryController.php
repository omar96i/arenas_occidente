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
            'equipments' => EquipmentMachinery::with('schedules')->get()
        ]);
    }

    public function getFuels($month, $year){

        $equipments_fuels = EquipmentMachinery::with(['fuelData' => function ($query) use ($month, $year) {
            $query->whereMonth('date', $month)->whereYear('date', $year);
        }])->get()->toArray();
        
        foreach ($equipments_fuels as &$equipment) {
            $given_fuel = EquipmentMachinery::givenFuel($equipment['id'], $month, $year);
            if ($given_fuel) {
                $equipment['fuel_data'][0]['gave'] = $given_fuel;
            }
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
