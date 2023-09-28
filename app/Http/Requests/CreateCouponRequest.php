<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCouponRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expire_date' => 'date',
            'quantity' => 'integer',
            'is_percent' => 'boolean',
            'result' => 'required|integer',
            'rules' => 'required|array',
            'rule.*.enum' => 'required|integer',
            'rule.*.rule_entries' => 'required',
        ];
    }

    protected function withValidator($validator)
    {
        $validator->sometimes('result', 'lte:100', function ($input) {
            return $input->is_percent;
        });
    }
}
