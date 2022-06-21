<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddXuatRequest extends FormRequest
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
            'blend'          => 'required',
            'ngay_pha'       => 'required',
            'kl_la'          => 'required|numeric',
            'kl_gialieu'     => 'required|numeric',
            'kl_thung_gl'     => 'required|numeric',
            // 'khoiluong'      => 'required'
        ];
    }
}
