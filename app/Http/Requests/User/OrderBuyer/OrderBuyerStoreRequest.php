<?php

namespace App\Http\Requests\User\OrderBuyer;

use Illuminate\Foundation\Http\FormRequest;

class OrderBuyerStoreRequest extends FormRequest
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
            'code' => 'unique:order_buyer,code',
        ];

    }
    public function messages(): array
    {
        return [
            'code.unique' => 'Mã đơn đặt hàng đã tồn tại',
        ];
    }
}
