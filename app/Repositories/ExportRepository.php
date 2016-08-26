<?php
/**
 * Created by PhpStorm.
 * User: Kanak
 * Date: 12/8/16
 * Time: 11:10 PM
 */

namespace App\Repositories;

class ExportRepository
{


    /**
     * @param $values
     * @param $fileName
     * @param $headers
     * @return string
     */
    public function exportData($values, $fileName, $headers)
    {
        $fileName = $fileName. rand(1, 1000) . '.xlsx';
        $filePath = storage_path('exports/') . $fileName;
        $file = new \SplFileObject($filePath, "a");
        // Add header to csv file.
        $file->fputcsv($headers);
        foreach ($values as $value) {
            $valueStatus = convertAttendanceFrom($value->status);
            $file->fputcsv([
                $value->id,
                $value->code,
                $value->name, $value->date, $value->day, $value->in_time, $value->out_time, $value->hours_worked, $value->difference, $valueStatus]);
        }

        return $fileName;


    }
}