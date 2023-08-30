<?php

namespace App\Http\Requests\User\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'supplier_code' => 'required|max:100|unique:suppliers,supplier_code',
            'name' => 'required|max:100',
            'address' => 'required|max:100',
            'tax_code' => 'required|max:100',
        ];
    }
    public function messages(): array
    {
        return [
            'supplier_code.required' => 'Mã nhà cung cấp là bắt buộc.',
            'supplier_code.unique' => 'Mã nhà cung cấp phải là duy nhất.',
            'supplier_code.max' => 'Giới hạn 100 ký tự.',
            'name.required' => 'Tên công ty là bắt buộc.',
            'name.max' => 'Giới hạn 100 ký tự.',
            'address.required' => 'Địa chỉ là bắt buộc.',
            'address.max' => 'Giới hạn 100 ký tự.',
            'tax_code.required' => 'Mã số thuế là bắt buộc.',
            'tax_code.max' => 'Giới hạn 100 ký tự.',
        ];
    }
}
