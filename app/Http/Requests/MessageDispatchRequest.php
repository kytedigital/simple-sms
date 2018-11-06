<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageDispatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channels' => 'required|array|message_service_enabled',
            'recipients' => 'required|array',
            'message' => 'required|string'
        ];
    }

    /**
     * use the JSON body data for validation instead of query params.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->json()->all();
    }
}
