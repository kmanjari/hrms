<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeaves extends Model
{
    public function leaveType()
    {
        return $this->hasOne('App\Models\LeaveType', 'id', 'leave_type_id');
    }
}
