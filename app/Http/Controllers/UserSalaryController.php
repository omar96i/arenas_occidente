<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\EntitySegment;
use App\Models\User;
use Illuminate\Http\Request;

class UserSalaryController extends Controller
{
    // listar usuarios y salarios
    public function getUsersSalary(EntitySegment $segment){
        $users_salary = User::whereHas('shifts', function ($query) use($segment){
            $query->where('entity_segment_id', $segment->id);
        })->with('contract_active', 'shifts.measure')->get();
        return response()->json(['users_salary'=> $users_salary]);
    }
}
