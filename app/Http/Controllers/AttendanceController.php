<?php

namespace App\Http\Controllers;

use App\Models\AttendanceManager;
use App\Models\Employee;
use App\Models\AttendanceFilename;
use App\Models\LeaveType;
use App\Repositories\ExportRepository;
use App\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceController extends Controller
{
    public $export;

    public function __construct(ExportRepository $exportRepository)
    {
        $this->export = $exportRepository;
    }

    public function importAttendanceFile()
    {
        $files = AttendanceFilename::paginate(5);
        return view('hrms.attendance.upload_file', compact('files'));
    }

    public function uploadFile(Request $request)
    {
        $file = Input::file('upload_file');
        $allowedext = ["xlsx", "xls"];
        $extension = $file->getClientOriginalExtension();
        $filename = $file->getClientOriginalName();
        if (in_array($extension, $allowedext)) {

            //move this file to storage path

            Input::file('upload_file')->move(storage_path('attendance/'), $filename);

            $instance = new AttendanceFilename();
            $instance->name = $filename;
            $instance->description = $request->description;
            $instance->date = date_format(date_create($request->date), 'Y-m-d');
            $instance->save();
        } else {
            \Session::flash('flash_message', 'Please upload only excel files with xls or xlsx extension');
            return redirect()->back();
        }

        try {
            Excel::load(storage_path('attendance/' . $filename), function ($reader) {
                $rows = $reader->get(['name', 'code', 'date', 'in_time', 'out_time', 'status']);

                foreach ($rows as $row) {
                    $hoursWorked = '';
                    if (strtotime($row->in_time) < strtotime('09:30:00')) {
                        $inTime = '09:30:00';
                        $hoursWorked = getHoursWorked($inTime, $row->out_time);

                    } elseif (strtotime($row->in_time) > strtotime('09:30:00')) {
                        $hoursWorked = getHoursWorked($row->in_time, $row->out_time);


                    }

                    $officeHours = '8:30:00';
                    if (strtotime($hoursWorked) > strtotime($officeHours)) {
                        $difference = strtotime($hoursWorked) - strtotime($officeHours);
                        $difference = '+' . $difference / 60 . 'minutes';

                    } else {
                        $difference = strtotime($officeHours) - strtotime($hoursWorked);
                        $difference = '-' . $difference / 60 . ' mins';

                    }


                    $user = Employee::where('code', $row->code)->first();
                    $attendance = new AttendanceManager();
                    $attendance->name = $row->name;
                    $attendance->code = $row->code;
                    $attendance->date = date_format(date_create($row->date), 'Y-m-d');
                    $attendance->day = covertDateToDay($row->date);
                    $attendance->in_time = $row->in_time;
                    $attendance->out_time = $row->out_time;
                    $attendance->status = convertAttendanceTo($row->status);
                    $attendance->user_id = $user->user_id;
                    $attendance->hours_worked = $hoursWorked;
                    $attendance->difference = $difference;
                    $attendance->save();
                    Session::flash('success', ' Uploaded successfully.');


                }
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        \Session::flash('flash_message1', 'File successfully Uploaded!');
        return redirect()->back();
    }

    public function showSheetDetails()
    {
        $column = '';
        $string = '';
        $attendances = AttendanceManager::paginate(20);
        return view('hrms.attendance.show_attendance_sheet_details', compact('attendances', 'column', 'string'));
    }

    public function doDelete($id)
    {
        $file = AttendanceFilename::find($id);
        $file->delete();

        \Session::flash('flash_message1', 'File successfully Deleted!');
        return redirect()->back();
    }

    public function searchAttendance(Request $request)
    {
        //try {
            $string = $request->string;
            $column = $request->column;

            $dateTo = date_format(date_create($request->dateTo), 'Y-m-d');
            $dateFrom = date_format(date_create($request->dateFrom), 'Y-m-d');

            if ($request->button == 'Search') {
                /**
                 * send the post data to getFilteredSearchResults function
                 * of AttendanceManager class in Models folder
                 */
                $attendances = AttendanceManager::getFilterdSearchResults($request->all());
                return view('hrms.attendance.show_attendance_sheet_details', compact('attendances', 'column', 'string'));
            } else {
                if ($column && $string) {
                    $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->get();
                } else {
                    $attendances = AttendanceManager::get();
                }

                $file = 'Attendance_Listing_';
                $headers = ['id', 'code', 'name', 'date', 'day', 'in_time', 'out_time', 'hours_worked', 'difference', 'status', 'created_at', 'updated_at'];

                /**
                 * sending the results fetched in above query to exportData
                 * function of ExportRepository class located in
                 * app\Repositories folder
                 */
                $fileName = $this->export->exportData($attendances, $file,$headers);


                return response()->download(storage_path('exports/') . $fileName);
            }

        /*} catch (\Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }*/
    }

}