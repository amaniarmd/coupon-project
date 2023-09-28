<?php

namespace App\Http\Requests;

class ApplyCouponRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|exists:coupons',
            'user_id' => 'required|integer|exists:users,id'
        ];
    }
}
