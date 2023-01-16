<?php

namespace App\Http\Requests;

use App\Rules\UserVerifyByDocumentRule;
use Illuminate\Foundation\Http\FormRequest;

class   UserVerifyRequest extends FormRequest
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
            'identification_type_id'    =>  'required',
            'identification_number'     =>  ['required', new UserVerifyByDocumentRule]
        ];
    }
}
