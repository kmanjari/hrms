<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveTypeApply extends Model
{
    protected $fillable = array('leave_type_id');

    public function leaveType()
    {
        return $this->hasOne('App\Models\LeaveType', 'id', 'leave_type_id');
    }

}
