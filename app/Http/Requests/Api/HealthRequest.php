<?php

namespace App\Http\Requests\Api;

class HealthRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'required|date',
            'gender' => 'required|in:m,f',
            'weight' => 'required',
            'height' => 'required|numeric',
            'exercise' => 'required',
            'purpose' => 'required',
            'habit' => 'required',
        ];
    }
}
