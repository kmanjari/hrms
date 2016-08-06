<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class IndexController extends Controller
{

    public function showPolicy(){
        return view('hrms.policies');
    }

    public function showForms(){

        return view('hrms.forms');
    }


}



