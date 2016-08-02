<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EmployeeRequest extends Request
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
            'full_final' => 'required',
            'emp_code' => 'required',
            'emp_name' => 'required',
            'emp_status' => 'required',
            'mob_number' => 'required|digits:10|',
            'doj' => 'date',
            'role' => 'required'
        ];
    }
}
