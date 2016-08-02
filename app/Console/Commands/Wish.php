<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;

class Wish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:wishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends an email wishing birthdays/work anniversary';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dateToday = date('Y-m-d');
        $users = \App\Models\Employee::whereRaw("DATE_FORMAT(`dob`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();
        $emps = \App\Models\Employee::whereRaw("DATE_FORMAT(`doj`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();


        foreach($users as $user)
        {
            //send an email
            $subject = " Happy Birthday $user->emp_name";
            $body= "Dear $user->emp_name, <br /> <br /> Digital Ip Insights wishes you a very happy birthday. Have fun and enjoy your day.<br /> <br /><img src='http://shetakesontheworld.com/wp-content/uploads/2012/01/shutterstock_59781901.jpg'> <br /><br /> Regards, <br /><br /> Digital Ip Insights Pvt. Ltd. ";
            $this->mailer->send('hrms.wishes.birthday', ['body' => $body], function($message) use($user, $subject)
            {
                $message->from('hr@dipi-ip.com', 'Digital IP Insights Pvt Ltd');
                $message->to($user->user->email, $user->name)->subject($subject);
            });
        }

        foreach($emps as $emp)
        {
            //send an email
            $subject = " Congratulations on Work Anniversary $emp->emp_name";
            $body= "Dear $emp->emp_name, <br /> <br /> Many congratulations for your work anniversary. Wish you loads of success for your future.<br /> <br /><img src='http://ak.imgag.com/imgag/product/postcards/3397536/550x400xgraphic1.jpg.pagespeed.ic.G_VtKZOtwJ.jpg'> <br /><br /> Regards, <br /><br /> Digital Ip Insights Pvt. Ltd. ";
            $this->mailer->send('hrms.wishes.anniversary', ['body' => $body], function($message) use($emp, $subject)
            {
                $message->from('hr@dipi-ip.com', 'Digital IP Insights Pvt Ltd');
                $message->to($emp->user->email, $emp->name)->subject($subject);
            });
        }





    }
}
