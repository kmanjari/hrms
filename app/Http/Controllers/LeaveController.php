<?php

namespace App\Http\Controllers;

use App\EmployeeLeaves;
use App\LeaveDraft;
use App\Models\Employee;
use App\Models\LeaveApply;
use App\Models\Role;
use App\Models\LeaveType;
use App\Models\Team;
use App\User;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;

class LeaveController extends Controller
{
    /**
     * LeaveController constructor.
     * @param Mailer $mailer
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addLeaveType()
    {
        return view('hrms.leave.add_leave_type');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function processLeaveType(Request $request)
    {
        $leave = new LeaveType;
        $leave->leave_type = $request->leave_type;
        $leave->description = $request->description;
        $leave->save();

        \Session::flash('flash_message', 'Leave Type successfully added!');
        return redirect()->back();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveType()
    {
        $leaves=LeaveType::paginate(5);
        return view('hrms.leave.show_leave_type',compact('leaves'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEdit($id)
    {
        $result= LeaveType::whereid ($id)->first();
        return view('hrms.leave.add_leave_type',compact('result'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    Public function doEdit(Request $request, $id)
    {
        $leave_type = $request->leave_type;
        $description = $request->description;

        $edit = LeaveType::findOrFail($id);
        if (!empty($leave_type)) {
            $edit->leave_type = $leave_type;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();

        \Session::flash('flash_message', 'Leave Type successfully updated!');
        return redirect('leave-type-listing');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doDelete($id)
    {
        $leave = LeaveType::find($id);
        $leave->delete();
        \Session::flash('flash_message1', 'Leave Type successfully Deleted!');
        return redirect('leave-type-listing');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doApply()
    {
        $leaves = LeaveType::get();
        return view('hrms.leave.apply_leave', compact('leaves'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processApply(Request $request)
    {
        $days = explode('days leave', $request->number_of_days);
        if(sizeof($days) <2)
        {
            $days = explode('day leave', $request->number_of_days);
        }
        $number_of_days = $this->wordsToNumber($days[0]);

        $team = Team::where('member_id', \Auth::user()->id)->first();
        $tl_id = $team->leader_id;
        $manager_id = $team->manager_id;

        $manager = Employee::where('id', $manager_id)->with('user')->first();
        $teamLead = Employee::where('id', $tl_id)->with('user')->first();

        $leave  = new EmployeeLeaves;
        $leave->employee_id = \Auth::user()->id;
        $leave->tl_id = $tl_id;
        $leave->manager_id = $manager_id;
        $leave->date_from= date_format(date_create($request->dateFrom),'Y-m-d');
        $leave->date_to = date_format(date_create($request->dateTo),'Y-m-d');
        $leave->from_time = $request->time_from;
        $leave->to_time = $request->time_to;
        $leave->reason = $request->reason;
        $leave->days = $number_of_days;
        $leave->status = '0';
        $leave->leave_type_id = $request->leave_type;
        $leave->save();

        $leaveType = LeaveType::where('id', $request->leave_type)->first();

        $emails[] = ['email' => $manager->user->email, 'name' => $manager->user->name];
        $emails[] = ['email' => $teamLead->user->email, 'name' => $teamLead->user->name];
        $emails[] = ['email' => env('HR_EMAIL'), 'name' => env('HR_NAME')];

        $leaveDraft = LeaveDraft::where('leave_type_id' , $request->leave_type)->first();

        $subject = $leaveDraft->subject;
        $user = \Auth::user();
        $toReplace = ['%name%', '%leave_type%', '%from_date%', '%to_date%', '%days%'];
        $replaceWith = [$user->name, $leaveType->leave_type, $request->dateFrom, $request->dateTo, $number_of_days];
        $body = str_replace($toReplace, $replaceWith, $leaveDraft->body);

        //now send a mail
        $this->mailer->send('emails.leave_approval', ['body' => $body], function($message) use($emails, $user, $subject)
        {
            foreach($emails as $email)
            {
                $message->from($user->email, $user->name);
                $message->to($email['email'], $email['name'])->subject($subject);
            }
        });


        \Session::flash('flash_message', 'Leave successfully applied!');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveRequest()
    {
        $emps= Employee::get();
        $leaves= LeaveApply::with('leavetypeapply.leavetype')->paginate(5);
        return view('hrms.leave.show_leave_request',compact('emps','leaves'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLeaveDraft()
    {
        $leaves = LeaveType::get();
        return view('hrms.leave.leave_draft', compact('leaves'));
    }

    /**
     * @param Requests\LeaveDraftRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLeaveDraft(Requests\LeaveDraftRequest $request)
    {
        $draft = new LeaveDraft;
        $draft->subject = $request->subject;
        $draft->body = $request->body;
        $draft->leave_type_id = $request->leave_type;
        $draft->save();

        \Session::flash('flash_message', 'Leave successfully drafted!');
        return redirect()->back();
    }

    /**
     * Convert a string such as "one hundred thousand" to 100000.00.
     *
     * @param string $data The numeric string.
     *
     * @return float or false on error
     */
    function wordsToNumber($data) {
        // Replace all number words with an equivalent numeric value
        $data = strtr(
            $data,
            array(
                'zero'      => '0',
                'a'         => '1',
                'one'       => '1',
                'two'       => '2',
                'three'     => '3',
                'four'      => '4',
                'five'      => '5',
                'six'       => '6',
                'seven'     => '7',
                'eight'     => '8',
                'nine'      => '9',
                'ten'       => '10',
                'eleven'    => '11',
                'twelve'    => '12',
                'thirteen'  => '13',
                'fourteen'  => '14',
                'fifteen'   => '15',
                'sixteen'   => '16',
                'seventeen' => '17',
                'eighteen'  => '18',
                'nineteen'  => '19',
                'twenty'    => '20',
                'thirty'    => '30',
                'forty'     => '40',
                'fourty'    => '40', // common misspelling
                'fifty'     => '50',
                'sixty'     => '60',
                'seventy'   => '70',
                'eighty'    => '80',
                'ninety'    => '90',
                'hundred'   => '100',
                'thousand'  => '1000',
                'million'   => '1000000',
                'billion'   => '1000000000',
                'and'       => '',
            )
        );

        // Coerce all tokens to numbers
        $parts = array_map(
            function ($val) {
                return floatval($val);
            },
            preg_split('/[\s-]+/', $data)
        );

        $stack = new \SplStack(); //Current work stack
        $sum   = 0; // Running total
        $last  = null;

        foreach ($parts as $part) {
            if (!$stack->isEmpty()) {
                // We're part way through a phrase
                if ($stack->top() > $part) {
                    // Decreasing step, e.g. from hundreds to ones
                    if ($last >= 1000) {
                        // If we drop from more than 1000 then we've finished the phrase
                        $sum += $stack->pop();
                        // This is the first element of a new phrase
                        $stack->push($part);
                    } else {
                        // Drop down from less than 1000, just addition
                        // e.g. "seventy one" -> "70 1" -> "70 + 1"
                        $stack->push($stack->pop() + $part);
                    }
                } else {
                    // Increasing step, e.g ones to hundreds
                    $stack->push($stack->pop() * $part);
                }
            } else {
                // This is the first element of a new phrase
                $stack->push($part);
            }

            // Store the last processed part
            $last = $part;
        }

        return $sum + $stack->pop();
    }

}
