<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\EntitySegment;
use App\Models\EntityShift;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EntityController extends Controller
{
    public function getEntities(){
        return response()->json([
            'status' => true,
            'entities' => Entity::with('segments.shifts.user')->get(),
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

    public function editShiftDate(Request $request, EntityShift $shift){
        $shift->update($request->all());
        return response()->json(['status' => true]);
    }

    public function storeShift(Request $request){

        foreach ($request->user as $key => $user) {
            if($request->date){
                $shift = new EntityShift([
                    'entity_segment_id' => $request->segment,
                    'user_id' => $user,
                    'schedule' => $request->schedule,
                    'date' => $request->date,
                ]);
                $shift->save();
            }else{
                $startDate = Carbon::parse($request->start);
                $endDate = Carbon::parse($request->end);
                $datesArray = [];

                while ($startDate->lte($endDate)) {
                    $datesArray[] = $startDate->toDateString(); // O puedes usar el formato que desees
                    $startDate->addDay(); // Avanzar al siguiente día
                }

                foreach ($datesArray as $key => $date) {
                    $shift = new EntityShift([
                        'entity_segment_id' => $request->segment,
                        'user_id' => $user,
                        'schedule' => $request->schedule,
                        'date' => $date,
                    ]);
                    $shift->save();
                }
            }
        }

        return response()->json([
            'status' => true,
            'msg' => 'completed',
        ]);
    }

    public function editShift(EntityShift $shift, Request $request){
        $shift->update([
            'entity_segment_id' => $request->segment,
            'schedule' => $request->schedule,
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'completed',
        ]);
    }

}
