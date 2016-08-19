<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceFilename extends Model
{
    public static function savefileName($filename, $description, $date)
    {
        $instance = new AttendanceFilename();
        $instance->name = $filename;
        $instance->description = $description;
        $instance->date = date_format(date_create($date), 'Y-m-d');
        $instance->save();
    }
}
