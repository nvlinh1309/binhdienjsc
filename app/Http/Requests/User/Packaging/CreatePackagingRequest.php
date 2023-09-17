<?php

namespace App\Http\Requests\User\Packaging;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackagingRequest extends FormRequest
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
            'name' => 'required|unique:packaging,name',
        ];

    }
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên bao bì',
            'name.unique' => 'Tên bao bì đã tồn tại',
        ];
    }
}
