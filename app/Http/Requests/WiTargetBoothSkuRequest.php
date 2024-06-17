<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $boothSku
 */
class WiTargetBoothSkuRequest extends FormRequest
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
            'items.*.id_targetbooth' => 'required',
            'items.*.skucode' => 'required',
            'items.*.skuqty' => 'required'
        ];
    }

    public function messages() : array
    {
        return [
            'items.*.id_targetbooth.required' => 'กรุณากรอกข้อมูลรหัสบูธเป้าหมายในรายการที่ :attribute',
            'items.*.skucode.required' => 'กรุณากรอกรหัส SKU ในรายการที่ :attribute',
            'items.*.skuqty.required' => 'กรุณากรอกจำนวน SKU ในรายการที่ :attribute'
        ];
    }
}
