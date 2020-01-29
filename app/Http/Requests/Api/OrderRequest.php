<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'recipes' => 'array',
            'diets' => 'array',
            'ingredients' => 'array',
            'address_id' => 'numeric',
            'deliver_at' => 'date_format:Y-m-d\TH:i:s'
        ];
    }
}
