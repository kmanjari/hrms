<?php

namespace App;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'emp_id');
    }
}
