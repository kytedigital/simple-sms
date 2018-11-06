<?php

namespace App\Models;

class Message
{
    public $recipient;

    public $message = '';

    /**
     * Message constructor.
     * @param array $recipient
     * @param string $message
     */
    public function __construct(array $recipient, string $message)
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

        foreach($this->recipient as $attribute => $value) {
            $message = str_replace('{'.$attribute.'}', $value, $message);
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
                        'to' => $this->recipient['phone'] ];
            default :
                return parent::toArray();
        }
    }
}
