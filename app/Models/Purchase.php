<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop', 'shop', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usages()
    {
        return $this->hasMany('App\Models\Usage');
    }

    /**
     * @return mixed
     */
    public function getRemaining()
    {
        $totalUsage = $this->usages()->sum('quantity');

        return $this->quantity - $totalUsage;
    }
}
