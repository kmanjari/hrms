<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Awardee extends Model
{
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function award()
    {
        return $this->hasOne('\App\Award', 'id', 'award_id');
    }
}
