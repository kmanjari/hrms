<?php

/**
 * Created by PhpStorm.
 * User: Kanak
 * Date: 13/8/16
 * Time: 10:43 PM
 */

namespace App\Repositories;


use App\EmployeeLeaves;
use App\Models\AttendanceManager;
use App\Models\Employee;
use App\Models\Holiday;
use Maatwebsite\Excel\Facades\Excel;

class ImportAttendanceData
{

    /**
     * @param $filename
     */
    public function Import($filename)
    {
        Excel::load(storage_path('attendance/' . $filename), function ($reader)
        {
            $rows = $reader->get(['name', 'code', 'date', 'days', 'in_time', 'out_time', 'hours_worked', 'over_time', 'status']);

            $counter = 0;
            $saturdays = 0;
            $totalSaturdaysBetweenDates = 0;
            $saturdayWithoutNotice = 0;
            foreach($rows as $row)
            {
                $date = $this->validateDate($row->date);
                if(!$date)
                {
                   echo $myDateTime = \DateTime::createFromFormat('Y/m/d', $row->date);
                    //$row->date = $myDateTime->format('d-m-y');
                }
                if($row->status == 'A')
                {
                    //check if user has applied for leave on this day
                    $user = Employee::where('code', $row->code)->first();
                    if($user)
                    {
                        $employeeLeave = EmployeeLeaves::where('user_id', $user->user_id)->where('date_from', '<=', $row->date)->where('date_to', '>=', $row->date)->first();

                        if($employeeLeave)
                        {
                            if($employeeLeave->status == '1')
                            {
                                $row->leave_status = 'Approved';
                            }
                            elseif ($employeeLeave->status == '2')
                            {
                                //set the leave_status column of this date as unapproved
                                $row->leave_status = 'Unapproved';
                            }
                            else
                            {
                                $row->leave_status = 'Pending';
                            }
                        }
                    }

                    if(!$row->leave_status)
                    {
                        if($row->days == 'Sat')
                        {
                            if($saturdays < 2)
                            {
                                $saturdays++;
                                $row->leave_status = 'Weekly Off';
                            }
                        }
                    }

                    if(!$row->leave_status)
                    {
                        $holidays = Holiday::get();

                        foreach($holidays as $holiday)
                        {
                            $dates = $this->createDateRangeArray($holiday->date_from, $holiday->date_to);
                            if(in_array($row->date, $dates))
                            {
                                $row->leave_status = $holiday->occasion. ' holiday';
                            }
                        }
                    }

                    if(!$row->leave_status)
                    {
                        $row->leave_status = 'Unplanned leave';
                    }
                }
                elseif($row->status == 'MIS')
                {
                    $row->leave_status = 'Missed punching';
                }
                elseif($row->status == 'WO')
                {
                    $row->leave_status = 'Sunday';
                }
                AttendanceManager::saveExcelData($row, $row->hours_worked, 0);
            }
            \Session::flash('success', ' Uploaded successfully.');
        });
    }

    public function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('d-m-Y',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('d-m-Y',$iDateFrom));
            }
        }
        return $aryRange;
    }

    public function changeDateFormat($date)
    {
        $dateArray = explode("/",$date); // split the array
        $varDay = $dateArray[0]; //day seqment
        $varMonth = $dateArray[1]; //month segment
        $varYear = $dateArray[2]; //year segment
        $newDateFormat = "$varYear-$varDay-$varMonth"; // join them together
        return $newDateFormat;
    }

    public function validateDate($date)
    {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
        {
            return true;
        }else{
            return false;
        }
    }
}