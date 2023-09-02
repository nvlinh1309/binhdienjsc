<?php

namespace App\Http\Requests\User\Storage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorageRequest extends FormRequest
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
            'code' => 'required|max:100|unique:storages,code,' . $this->id,
            'name' => 'required|max:100',
            'address' => 'required|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã kho là bắt buộc',
            'code.unique' => 'Mã kho phải là duy nhất',
            'code.max' => 'Giới hạn 100 ký tự',
            'name.required' => 'Tên kho là bắt buộc',
            'name.max' => 'Giới hạn 100 ký tự',
            'address.required' => 'Địa chỉ là bắt buộc',
            'address.max' => 'Giới hạn 100 ký tự',
        ];
    }
}
