<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DownloadController extends Controller
{
    public function downloadForms($name)
    {
        $pathToFile = public_path('forms/'). $name;
        return response()->download($pathToFile);
    }
}
