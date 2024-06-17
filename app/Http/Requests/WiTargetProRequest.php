<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WiTargetProRequest extends FormRequest
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
            '*.pro_month' => 'required|date_format:Y-m-d',
            '*.cust_id' => 'required|string',
            '*.pro_sku' => 'required|string',
            '*.pro_desc' => 'required|string',
            '*.pro_name' => 'required|string',
        ];
    }

    public function messages() : array
    {
        return [
            '*.pro_month.required' => 'ต้องระบุเดือนของโปรโมชั่น',
            '*.pro_month.date_format' => 'เดือนของโปรโมชั่นต้องอยู่ในรูปแบบ YYYY-MM-DD',
            '*.cust_id.required' => 'ต้องระบุรหัสลูกค้า',
            '*.pro_sku.required' => 'ต้องระบุรหัส SKU ของสินค้า',
            '*.pro_desc.required' => 'ต้องระบุคำอธิบายสินค้า',
            '*.pro_name.required' => 'ต้องระบุชื่อสินค้า',
        ];
    }
}
