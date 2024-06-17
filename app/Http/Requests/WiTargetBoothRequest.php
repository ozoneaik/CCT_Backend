<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WiTargetBoothRequest extends FormRequest
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
            'startdate' => 'required',
            'enddate' => 'required',
            'booth_month' => 'required',
            'custid' => 'required',
        ];
    }

    public function message() : array
    {
        return [
            'startdate.required' => 'Start date is required.',
            'enddate.required' => 'End date is required.',
            'booth_month.required' => 'Booth month is required.',
            'custid.required' => 'Custid is required.',
        ];
    }
}
