<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LeaveDraftRequest extends Request
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
            'subject' => 'required|min:10|max:100',
            'body' => 'required|max:1000',
            'leave_type' => 'required',
        ];
    }
}
