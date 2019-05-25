<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LifecycleCustomersDeleteRequest extends FormRequest
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
            'shop_domain' => 'string|required',
            'shop_id' => 'int|required',
            'customer' => 'string|required',
            'orders_requested' => 'array|required'
        ];
    }
}
