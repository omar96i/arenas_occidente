<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\EntitySegment;
use App\Models\EntityShift;
use App\Models\User;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function getEntities(){
        return response()->json([
            'status' => true,
            'entities' => Entity::with('segments.shifts.user', 'segments.shifts.measure', 'measures')->get(),
            'employees' => User::get(),
        ]);
    }

    public function getEmployees(EntitySegment $segment){
        return response()->json([
            'status' => true,
            'employees' => User::whereHas('shifts', function($query) use($segment){
                $query->where('entity_segment_id', $segment->id);
            })->get()
        ]);
    }

    public function storeSegment(Request $request){
        $segment = new EntitySegment($request->all());
        $segment->save();
        return response()->json([
            'status' => true,
        ]);
    }

    public function getShift(EntityShift $shift){
        return response()->json([
            'status' => true,
            'shift' => $shift->load('user')
        ]);
    }

    public function deleteShift(EntityShift $shift){
        $shift->delete();
        return response()->json([
            'status' => true,
        ]);
    }

    public function storeShift(Request $request){

        $entitySegment = EntitySegment::find($request->segment);


        // Luego, realizamos las validaciones personalizadas
        $existingShift = EntityShift::where('date', $request->date)
            ->where('entity_measure_id', $request->measure)
            ->where('user_id', $request->user)
            ->where('entity_segment_id', $entitySegment->id)
            ->first();

        if ($existingShift) {
            return response()->json([
                'status' => false,
                'msg' => 'Ya existe un turno con la misma fecha, medida, usuario y segmento de entidad.'
            ]);
        }

        $limit_time = $entitySegment->time_limit;
        $total_time = 0;
        $shifts = EntityShift::where('user_id', $request->user)->where('entity_segment_id', $entitySegment->id)->with('measure')->get();

        foreach ($shifts as $shift) {
            switch ($shift->measure->description) {
                case 'Primer turno: de 6am-2pm':
                case 'Segundo turno: de 2pm-10pm':
                case 'Tercer turno: de 10pm-6am':
                    $total_time += 8;
                    break;
                case 'Turno día fin de semana: de 6am-6pm':
                case 'Turno noche fin de semana: de 6pm-6am':
                    $total_time += 12;
                    break;
                case 'Descanso':
                    // No se suma tiempo en este caso
                    break;
            }
        }

        if ($total_time >= $limit_time) {
            return response()->json([
                'status' => false,
                'msg' => 'El usuario sobrepasa las horas asignadas'
            ]);
        }

        $shift = new EntityShift([
            'entity_segment_id' => $request->segment,
            'user_id' => $request->user,
            'entity_measure_id' => $request->measure,
            'date' => $request->date,
        ]);
        $shift->save();

        return response()->json([
            'status' => true,
            'msg' => 'completed',
        ]);
    }

    public function editShift(EntityShift $shift, Request $request){
        $shift->update([
            'entity_segment_id' => $request->segment,
            'user_id' => $request->user,
            'entity_measure_id' => $request->measure,
            'date' => $request->date,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'completed',
        ]);
    }

}
