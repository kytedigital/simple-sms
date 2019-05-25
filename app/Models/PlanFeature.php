<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    /**
     * Get the user that owns the phone.
     */
    public function plan()
    {
        return $this->belongsTo('App\Models\Plan', 'plan_id');
    }
}
