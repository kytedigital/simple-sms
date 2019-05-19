<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $toDateTimeString)
 */
class Token extends Model
{
    protected $fillable = [
        'type',
        'shop',
        'token',
        'expires_at'
    ];
}
