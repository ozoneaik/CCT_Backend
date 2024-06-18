<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WiTargetTrainRequest extends FormRequest
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
            'trainstart' => 'required',
            'trainend' => 'required',
        ];
    }

    public function messages() : array
    {
        return [
            'cust_id.required' => 'กรุณาระบุรหัสลูกค้า',
            'target_month.required' => 'กรุณาระบุเดือนเป้าหมาย',
            'trainstart.required' => 'กรุณาระบุวันเริ่มต้นการฝึกอบรม',
            'trainend.required' => 'กรุณาระบุวันสิ้นสุดการฝึกอบรม',
        ];
    }
}
