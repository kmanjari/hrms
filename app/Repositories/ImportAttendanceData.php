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
            $rows = $reader->get(['name', 'code', 'date', 'in_time', 'out_time', 'status']);

            $counter = 0;
            $totalSaturdaysBetweenDates = 0;
            foreach ($rows as $row)
            {
                if ($row->status == 'A')
                {
                    $employee = Employee::where('code', $row->code)->first();
                    $userId = $employee->user_id;

                    $day = covertDateToDay($row->date);
                    if ($day != 'SUNDAY' && $day != 'SATURDAY')
                    {
                        $employeeLeave = EmployeeLeaves::where('user_id', $userId)->where('date_from', '<=', $row->date)->where('date_to', '>=', $row->date)->first();

                        //we now check if we got result from the above query
                        if ($employeeLeave)
                        {
                            if ($employeeLeave->status == '1')
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
                        else
                        {
                            $row->leave_status = 'Unplanned';
                        }
                    }
                    elseif ($day == 'SUNDAY')
                    {
                        $row->leave_status = 'It was Sunday ';
                    }
                    elseif($day == 'SATURDAY')
                    {
                        /*$saturday +=1;
                        if($saturday >2)
                        {
                            $extraSaturday+=1;
                        }*/

                        if($counter == 0)
                        {
                            $lastMonth = date('m', strtotime('-1 month'));
                            //$presentMonth = date('m', strtotime('month'));
                            $year = date('Y');
                            $month = date('m');
                            $startDate = "$year-$lastMonth-26";
                            /*$endDate = date('Y-m-d');*/
                            $endDate = "$year-$month-25";

                            $query = "SELECT date_from,date_to,status FROM `employee_leaves` WHERE `user_id` = $userId AND `date_from` BETWEEN '$startDate' AND '$endDate' AND `date_to` BETWEEN '$startDate' AND '$endDate'";
                            $results = \DB::select($query);

                            if ($results)
                            {
                                foreach ($results as $result)
                                {
                                    if($result->status == 0)
                                    {
                                        //pending
                                        $row->status = 'Unapproved';
                                    }
                                    elseif($result->status = 1)
                                    {
                                        //approved
                                        $dates = $this->createDateRangeArray($result->date_from, $result->date_to);
                                        foreach ($dates as $date)
                                        {
                                            $newDate = covertDateToDay($date);
                                            if ($newDate == 'SATURDAY')
                                            {
                                                $totalSaturdaysBetweenDates += 1;
                                                $row->leave_status = 'Planned';
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $row->status = 'Unapproved';
                                    }
                                }
                            }
                        }
                        $counter +=1;
                        $extra_saturdays = ($totalSaturdaysBetweenDates + $counter) - 2;
                        if(!isset($row->leave_status))
                        {
                        $row->leave_status = 'Unplanned';
                        }
                    }

                }
                $hoursWorked = '';
                if (strtotime($row->in_time) < strtotime('09:30:00'))
                {
                    $inTime = '09:30:00';
                    $hoursWorked = getHoursWorked($inTime, $row->out_time);

                }
                elseif (strtotime($row->in_time) > strtotime('09:30:00'))
                {
                    $hoursWorked = getHoursWorked($row->in_time, $row->out_time);
                }

                $officeHours = '8:30:00';
                if (strtotime($hoursWorked) > strtotime($officeHours))
                {
                    $difference = strtotime($hoursWorked) - strtotime($officeHours);
                    $difference = '+' . $difference / 60 . 'minutes';

                }
                else
                {
                    $difference = strtotime($officeHours) - strtotime($hoursWorked);
                    $difference = '-' . $difference / 60 . ' mins';
                }

                AttendanceManager::saveExcelData($row, $hoursWorked, $difference);

                \Session::flash('success', ' Uploaded successfully.');
            }
            \Log::info('total saturdays with leave '. $totalSaturdaysBetweenDates);
            \Log::info('total saturdays without leave'. $counter);
            \Log::info('extra saturdays(all-2) '. $extra_saturdays);

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
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }
}