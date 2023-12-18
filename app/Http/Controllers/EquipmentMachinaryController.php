<?php

namespace App\Http\Controllers;

use App\Models\EquipmentMachinery;
use Illuminate\Http\Request;

class EquipmentMachinaryController extends Controller
{
    public function get(){
        return response()->json([
            'status' => true,
            'equipments' => EquipmentMachinery::with('schedules')->get()
        ]);
    }
}
