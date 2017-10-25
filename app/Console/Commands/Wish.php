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
    protected $signature = 'kanak:wishes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sends an email wishing birthdays/work anniversary';


    /**
     * Wish constructor.
     * @param Mailer $mailer
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
        $users = \App\Models\Employee::whereRaw("DATE_FORMAT(`date_of_birth`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();
        $emps = \App\Models\Employee::whereRaw("DATE_FORMAT(`date_of_joining`, '%m-%d') = DATE_FORMAT('$dateToday', '%m-%d')")->with('user')->get();


        foreach($users as $user)
        {
            $this->info('emp id '. $user->id);
            $this->info('emp user id '. $user->user_id);
            $this->info($user->user->email);
            //send an email
            $subject = " Happy Birthday $user->name";
            $body= "Dear $user->name, <br /> <br /> Digital IP Insights wishes you a very happy birthday. Have fun and enjoy your day.
            <br /> <br />
            <img src='http://shetakesontheworld.com/wp-content/uploads/2012/01/shutterstock_59781901.jpg'>
            <br /><br />
            Best Wishes, <br /><br /> Digital IP Insights Pvt. Ltd. ";
            $this->mailer->send('hrms.wishes.birthday', ['body' => $body], function($message) use($user, $subject)
            {
                $message->from('hr@dipi-ip.com', 'Digital IP Insights Pvt Ltd');

                $message->to($user->user->email, $user->name)->subject($subject);
            });
        }

        foreach($emps as $emp)
        {
            //send an email
            $subject = " Congratulations on Work Anniversary $emp->name";
            $body= "Dear $emp->name, <br /> <br /> Many congratulations for your work anniversary. Wish you loads of success for your future.
            <br /> <br />
            <img src='http://ak.imgag.com/imgag/product/postcards/3397536/550x400xgraphic1.jpg.pagespeed.ic.G_VtKZOtwJ.jpg'>
            <br /><br />
            Best Wishes, <br /><br /> Digital IP Insights Pvt. Ltd. ";
            $this->mailer->send('hrms.wishes.anniversary', ['body' => $body], function($message) use($emp, $subject)
            {
                $message->from('hr@dipi-ip.com', 'Digital IP Insights Pvt Ltd');
                $message->to($emp->user->email, $emp->name)->subject($subject);
            });
        }





    }
}
