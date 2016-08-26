<?php
/**
 * Created by PhpStorm.
 * User: Kanak
 * Date: 13/8/16
 * Time: 10:13 PM
 */

namespace App\Repositories;


use App\Models\AttendanceFilename;

class UploadRepository
{

    public function File($file, $description, $date)
    {
        $allowedext = ["xlsx", "xls"];
        $extension = $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        if (in_array($extension, $allowedext)) {

            //move this file to storage path
            $file->move(storage_path('attendance/'), $filename);

            AttendanceFilename::savefileName($filename, $description, $date);

            return $filename;
        } else {
            \Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');
            return redirect()->back();
        }
    }
}