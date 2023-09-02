<?php

namespace App\Http\Requests\User\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'code' => 'required|max:100|unique:customers,code',
            'name' => 'required|max:100',
            'tax' => 'required|integer',
            'tax_code' => 'required',
            'address' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Mã khách hàng là bắt buộc',
            'code.max' => 'Giới hạn 100 ký tự',
            'code.unique' => 'Mã khách hàng phải là duy nhất',
            'name.required' => 'Tên khách hàng phải là bắt buộc',
            'name.max' => 'Giới hạn 100 ký tự',
            'tax.required' => 'Thuế suất là bắt buộc',
            'tax.integer' => 'Thuế xuất phải là dạng số',
            'tax_code.required' => 'Mã số thuế là bắt buộc',
            'address.required' => 'Địa chỉ là bắt buộc',
            'contact_email.required' => 'Email là bắt buộc',
            'contact_email.email' => 'Không đúng định dạng email',
            'contact_phone.required' => 'Điện thoại là bắt buộc',
            'contact_phone.numeric' => 'Không đúng định dạng điện thoại'
        ];
    }
}
