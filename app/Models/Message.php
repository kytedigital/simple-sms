<?php

namespace App\Models;

use Illuminate\Support\Collection;

class Message
{
    public $recipient;

    public $message = '';

    /**
     * Message constructor.
     * @param Collection $recipient
     * @param string $message
     */
    public function __construct(Collection $recipient, string $message)
    {
        $this->recipient = $recipient;
        $this->message = $message;
    }

    /**
     * @return mixed|string
     */
    protected function preparedMessage()
    {
        $message = $this->message;

        foreach($this->recipient->get('shop') as $attribute => $value) {
            $message = str_replace('{shop.' . $attribute . '}', $value, $message);
        }

        foreach($this->recipient->first() as $attribute => $value) {
            if(is_object($value)) continue;
            $message = str_replace('{' . $attribute . '}', $value, $message);
        }

        return $message;
    }

    /**
     * @param null $type
     * @return array
     */
    public function __toArray($type = null) : array
    {
        switch($type) {
            case 'sms' :
                return ['message' => $this->preparedMessage(),
                        'to' => $this->recipient->first()['phone'] ];
            default :
                return parent::toArray();
        }
    }
}
