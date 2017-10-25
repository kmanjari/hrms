<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingInvite extends Model
{
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function program()
    {
        return $this->hasOne(TrainingProgram::class, 'id', 'program_id');
    }
}
