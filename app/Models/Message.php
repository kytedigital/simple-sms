<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = [
        'recipients',
        'message',
    ];

    public $recipients = [];


    public $message = '';

    /**
     * @return array
     */
    public function toArray($type = null) : array
    {
        switch($type) {
            case 'sms' :
                return array_merge(
                    parent::toArray(),
                    ['to' =>
                        implode(
                            ',',
                            array_pluck($this->getAttribute('recipients'), 'phone')
                        )
                    ]
                );
            default :
                return parent::toArray();
        }
    }
}