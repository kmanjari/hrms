<?php

namespace App\Http\Controllers;

use App\Models\AttendanceUpload;
use App\Models\Employee;
use App\Models\Filename;
use App\Models\LeaveApply;
use App\Models\Role;
use App\Models\LeaveType;
use App\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceController extends Controller
{
    public function importAttendanceFile()
    {
        $files = Filename::paginate(5);
        return view('hrms.attendance.upload_file', compact('files'));
    }

    public function uploadFile(Request $request)
    {
        $file = Input::file('upload_file');
        $allowedext = ["xlsx", "xls"];
        $extension = $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        if (in_array($extension, $allowedext)) {

            $instance = new Filename();
            $instance->name = $filename;
            $instance->description = $request->description;
            $instance->date = date_format(date_create($request->date), 'Y-m-d');
            $instance->save();
        } else {
            \Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');
            return redirect()->back();
        }


        try {
            Excel::load($file, function ($reader) {
                $rows = $reader->get(['id', 'name', 'seller_name']);


                //DB::table('attachments')->insert($rows);
                foreach ($rows as $row) {
                    $attachment = new AttendanceUpload();
                    $attachment->name = $row->name;
                    $attachment->seller_name = $row->seller_name;
                    $attachment->save();
                    Session::flash('success', ' Uploaded successfully.');

                }
                //return redirect('upload_form');*/
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        \Session::flash('flash_message1', 'File successfully Uploaded!');
        return redirect()->back();
    }

    public function doDelete($id)
    {
        $file = Filename::find($id);
        $file->delete();

        \Session::flash('flash_message1', 'File successfully Deleted!');
        return redirect()->back();
    }

}
