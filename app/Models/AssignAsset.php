<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignAsset extends Model
{
    public function employee()
    {
        return $this->hasOne('\App\Models\Employee', 'id', 'emp_id');
    }

    public function asset()
    {
        return $this->hasOne('\App\Models\Asset', 'id', 'asset_id');
    }
}
