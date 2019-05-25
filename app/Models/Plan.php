<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * Get the plan that owns the feature.
     */
    public function features()
    {
        return $this->hasMany('App\Models\PlanFeature');
    }
}
