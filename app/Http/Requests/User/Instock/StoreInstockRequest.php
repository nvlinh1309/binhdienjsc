<?php

namespace App\Http\Requests\User\Instock;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstockRequest extends FormRequest
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
            'order_code' => 'required|unique:goods_receipt_management,goods_receipt_code',
        ];

    }

    public function messages(): array
    {
        return [
            'order_code.required' => 'Vui lòng không bỏ trống Mã đặt hàng.',
            'order_code.unique' => 'Giá trị mã nhập kho phải là duy nhất.'
        ];
    }
}
