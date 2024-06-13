<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WiTargetSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        return [
            'cust_id' => 'required',
            'target_month' => 'required',
            'target_sale' => 'required|numeric|min:0',
        ];
    }

    public function message() : array
    {
        return [
            'cust_id.required' => 'จำเป็นต้องมีรหัสลูกค้า',
            'target_month.required' => 'จำเป็นต้องมีเดือนเป้าหมาย',
            'target_sale.required' => 'จำเป็นต้องมียอดขายเป้าหมาย',
        ];
    }
}
