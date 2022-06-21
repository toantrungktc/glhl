<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeyRequest extends FormRequest
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
            'name' => 'required',
            'loai' => 'required',
            'ngay_kich_hoat' => 'required',
            'ngay_het_han' => 'required',
            'ngay_canh_bao' => 'required',
        ];
    }
}
