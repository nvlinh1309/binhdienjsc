<?php

namespace App\Http\Requests\User\Packaging;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackagingInputRequest extends FormRequest
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
            'quantity' => 'required|numeric|min:1',
        ];

    }
    public function messages(): array
    {
        return [
            'quantity.required'     => 'Vui lòng nhập số lượng',
            'quantity.numeric'      => 'Số lượng phải là số nguyên dương',
            'quantity.min'          => 'Số lượng phải lớn 0'
        ];
    }
}
