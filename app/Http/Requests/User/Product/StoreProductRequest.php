<?php

namespace App\Http\Requests\User\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|max:100|min:1|unique:products,name',
            'barcode' => 'required|min:5',
            'brand_id' => 'required',
            'specification' => 'required',
            'unit' => 'required',
            'price' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Giới hạn 100 ký tự',
            'name.unique' => 'Tên sản phẩm phải là duy nhất',
            'barcode.required' => 'Barcode phải là bắt buộc',
            'brand_id.required' => 'Thương hiệu phải là bắt buộc',
            'specification.required' => 'Quy cách là bắt buộc',
            'unit.required' => 'Mã số thuế là bắt buộc',
            'address.required' => 'Đơn vị tính là bắt buộc',
            'price.required' => 'Giá sản phẩm là bắt buộc',
        ];
    }
}
