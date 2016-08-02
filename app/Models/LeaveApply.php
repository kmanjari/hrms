<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApply extends Model
{
    public function leavetypeapply()
    {
        return $this->hasOne('App\Models\LeaveTypeApply', 'leave_apply_id', 'id');
    }
}
