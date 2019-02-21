<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $shop)
 */
class MessageLog extends Model
{
    //
    protected $fillable = [
        'message',
        'status',
        'recipients',
        'responseMessage',
        'channel',
        'sendCount',
        'shop'
    ];
}
