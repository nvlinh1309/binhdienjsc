<?php

namespace App\Http\Requests\User\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'supplier_id' => 'required',
            'name' => 'required|max:100|unique:brands,name',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => 'Nhà cung cấp là bắt buộc.',
            'name.unique' => 'Tên thương hiệu phải là duy nhất.',
            'name.max' => 'Giới hạn 100 ký tự.',
            'name.required' => 'Tên thương hiệu là bắt buộc.',
        ];
    }
}
