<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
