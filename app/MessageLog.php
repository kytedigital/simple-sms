<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
