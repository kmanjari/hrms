Dear {{$user->name}},

<br/><br/>
@if($status == 'approved')
    Congratulations ! Your leave request for {{getLeaveType($leave->leave_type_id)}} for {{$leave->days}} day(s)
    has been approved.
@else
    Unfortunately your leave request for {{getLeaveType($leave->leave_type_id)}} for {{$leave->days}} day(s) cannot be approved due to many
    circumstances. Please see HR Manager or your Team Lead for clarifications
@endif
<br />
<br />

Thanks & Regards
<br />
Human Resource Department
<br />
Digital IP Insights
