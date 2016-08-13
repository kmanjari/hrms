<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceManager extends Model
{
    public static function getFilterdSearchResults($request)
    {
        $string = $request['string'];
        $column = $request['column'];

        $dateTo =  date_format(date_create($request['dateTo']), 'Y-m-d');
        $dateFrom =  date_format(date_create($request['dateFrom']), 'Y-m-d');

        if($column && $string)
        {
            $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->paginate(20);
        }
        elseif($column && $string && isset($dateFrom) && isset($dateTo)) {
            $attendances = AttendanceManager::whereRaw($column . " like '%" . $string . "%'")->whereBetween('date', [$dateFrom, $dateTo])->paginate(20);
        }
        elseif(isset($dateFrom) && isset($dateTo))
        {
            $attendances = AttendanceManager::whereBetween('date', [$dateFrom, $dateTo])->paginate(20);
        }
        else
        {
            $attendances = AttendanceManager::paginate(20);
        }

        return $attendances;
    }
}
