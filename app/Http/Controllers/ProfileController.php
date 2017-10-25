<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileController extends Controller
{
    public function show(){

        $details = Employee::where('user_id', \Auth::user()->id)->with('userrole.role')->first();
        $events = $this->convertToArray(Event::where('date', '>', Carbon::now())->orderBy('date','desc')->take(3)->get());
        return view('hrms.profile', compact('details','events'));
    }
    public function convertToArray($values)
    {
        $result = [];
        foreach($values as $key => $value)
        {
            $result[$key] = $value;
        }
        return $result;
    }
}
