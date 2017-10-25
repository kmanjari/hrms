<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function replies()
    {
        return $this->hasMany(PostReply::class);
    }
}
