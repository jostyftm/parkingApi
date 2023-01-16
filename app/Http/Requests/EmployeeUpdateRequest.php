<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'name'                      =>  'required',
            'last_name'                 =>  'required',
            'identification_type_id'    =>  'required',
            'identification_number'     =>  'required',
            'email'                     =>  'required|unique:users,id,'.$this->client->user_id,
        ];
    }
}