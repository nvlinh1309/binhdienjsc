<?php

namespace App\Http\Requests\User\OrderSeller;

use Illuminate\Foundation\Http\FormRequest;

class OrderSellerStoreRequest extends FormRequest
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
            'to_deliver_code' => 'unique:order_seller,to_deliver_code',
        ];

    }
    public function messages(): array
    {
        return [
            'to_deliver_code.unique' => 'Mã xuất kho đã tồn tại',
        ];
    }
}
