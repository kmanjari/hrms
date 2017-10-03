<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class AssignProject extends Model
{
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function authority()
    {
        return $this->hasOne(User::class, 'id', 'authority_id');
    }

    public function project()
    {
        return $this->hasOne('\App\Models\Project', 'id', 'project_id');
    }
}