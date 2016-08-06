<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Facades\Excel;

class ExportData extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $request;
    public $user;
    public $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $user, $type)
    {
        $this->request = $request;
        $this->user = $user;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->type == 'employee') {
            if ($this->request->column == 'email') {
            }
            $emps = User::with('employee')->where($this->request->column, $this->request->string)->paginate(20);
        } else {
            $emps = User::whereHas('employee', function ($q) {
                $q->whereRaw($this->request->column . " like '%" . $this->request->string . "%'");
            })
                ->with('employee')
                ->get();
        }

        Excel::create('Filename', function($excel) use($emps) {

            $excel->sheet('Sheetname', function($sheet) use($emps) {

                $sheet->fromArray($emps);

            });

        })->export('xls');
    }
}
