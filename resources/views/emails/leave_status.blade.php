Dear {{$user->name}},

<br/><br/>
@if($status == 'approved')
    Congratulations ! Your leave request for {{getLeaveType($leave->leave_type_id)}} for {{$leave->days}} day(s)
    has been approved with the following remark <i>"{{$remarks}}"</i>.
@else
    Unfortunately your leave request for {{getLeaveType($leave->leave_type_id)}} for {{$leave->days}} day(s) cannot be approved
    with the following remark <i>"{{$remarks}}"</i>.
@endif
<br />
<br />

Thanks & Regards
<br />
Human Resource Department
<br />
Digital IP Insights
