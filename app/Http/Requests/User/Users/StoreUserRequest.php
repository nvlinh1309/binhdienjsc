<?php

namespace App\Http\Requests\User\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Họ tên là bắt buộc.',
            'name.max' => 'Giới hạn 100 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Không đúng định dạng email',
            'email.unique' => 'Địa chỉ email phải là duy nhất.',
            'role.required' => 'Vai trò là bắt buộc.',
        ];
    }
}
