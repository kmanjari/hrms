<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceManager extends Model
{
    public static function getFilterdSearchResults($request)
    {
        $string = $request['string'];
        $column = $request['column'];
        if($column == 'status')
        {
            $string = convertAttendanceTo($string);
        }
        $dateTo =  date_format(date_create($request['dateTo']), 'Y-m-d');
        $dateFrom =  date_format(date_create($request['dateFrom']), 'Y-m-d');

        if(!empty($column) && !empty($string) && empty($dateFrom) && empty($dateTo))
        {
            $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->paginate(20);
        }
        elseif(!empty($dateFrom) && !empty($dateTo) && empty($column) && empty($string))
        {
            $attendances = AttendanceManager::whereBetween('date', [$dateFrom, $dateTo])->paginate(20);
        }
        elseif(!empty($column) && !empty($string) && !empty($dateFrom) && !empty($dateTo)) {
            $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->whereBetween('date', [$dateFrom, $dateTo])->paginate(20);
        }
        else
        {
            $attendances = AttendanceManager::paginate(20);
        }

        return $attendances;
    }

    public static function saveExcelData($row, $hoursWorked, $difference)
    {
        $user = Employee::where('code', $row->code)->first();
        $attendance = new AttendanceManager();
        $attendance->name = $row->name;
        $attendance->code = $row->code;
        $attendance->date = date_format(date_create($row->date), 'Y-m-d');
        $attendance->day = covertDateToDay($row->days);
        \Log::info('inTime='.$row->in_time);
        $attendance->in_time = isset($row->in_time)? $row->in_time : 'H:i:s' ;
        $attendance->out_time = isset($row->out_time)? $row->out_time : 'H:i:s';
        $attendance->status = convertAttendanceTo(preg_replace('/\s+/', '', $row->status));
        $attendance->leave_status = $row->leave_status;
        $attendance->user_id = $user->user_id;
        $attendance->hours_worked = $hoursWorked;
        $attendance->difference = $difference;
        $attendance->save();
    }
}
