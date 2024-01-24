<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceScheduling;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MaintenanceSchedulingController extends Controller
{
    public function store(Request $request){

        $maintenance = new MaintenanceScheduling($request->all());
        $maintenance->save();

        return response()->json(['status' => true, 'maintenance' => $maintenance]);

    }

    public function get(MaintenanceScheduling $scheduling){

        return response()->json(['status' => true, 'scheduling' => $scheduling]);

    }

    public function update(Request $request, MaintenanceScheduling $scheduling){

        $scheduling->update($request->all());
        return response()->json(['status' => true]);

    }

    public function delete(MaintenanceScheduling $scheduling){

        $scheduling->delete();
        return response()->json(['status' => true]);

    }

    public function getToday(){
        // Registros del día de hoy
        $schedulingsToday = MaintenanceScheduling::with('equipment', 'user')
        ->whereDate('date', Carbon::now())
        ->where('status', '!=', 'COMPLETO')
        ->get();

        // Registros anteriores a hoy con estado 'PASADO'
        $schedulingsPast = MaintenanceScheduling::with('equipment', 'user')
        ->whereDate('date', '<', Carbon::now())
        ->where('status', 'PASADO')
        ->get();
        return response()->json([
            'status' => true,
            'schedulings' => array_merge($schedulingsToday->toArray(), $schedulingsPast->toArray())
        ]);
    }
}
