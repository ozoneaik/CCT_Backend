<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $skus
 */
class WiTargetNewSkuRequest extends FormRequest
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
            '*skus.custid' => 'required',
            '*skus.new_sku' => 'required',
            '*skus.new_target_sale' => 'required',
            '*skus.new_target_month' => 'required'
        ];
    }

    public function message() : array
    {
        return [
            '*skus.custid.required' => 'กรุณาระบุรหัสลูกค้า',
            '*skus.new_sku.required' => 'กรุณาระบุรหัสสินค้าใหม่',
            '*skus.new_target_sale.required' => 'กรุณาระบุยอดขายเป้าหมายใหม่',
            '*skus.new_target_month.required' => 'กรุณาระบุเดือนเป้าหมายใหม่'
        ];
    }
}
