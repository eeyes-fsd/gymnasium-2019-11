<?php

namespace App\Http\Requests\Api;

class AddressRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'phone' => [
                'required',
                'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'
            ],
            'gender' => 'required|in:f,m',
            'street' => 'required',
            'details' => 'required'
        ];
    }
}
