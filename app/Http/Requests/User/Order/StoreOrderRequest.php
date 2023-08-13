<?php

namespace App\Http\Requests\User\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'order_code' => 'required|unique:orders,order_code,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'order_code.required' => 'Mã đơn hàng là bắt buộc.',
            'order_code.unique' => 'Mã đơn hàng phải là duy nhất.'
        ];
    }
}
