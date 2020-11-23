<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
        $validationRules = [
            'first_name' => 'required|min:3|max:20',
            'last_name' => 'required|min:3|max:20',
            'email' => 'required|email',
        ];

        if ($this->request->get('current-password') != null) {
            $validationRules += [
                'current-password' => 'required',
                'new-password' => 'required|string|min:6|confirmed',
            ];
        }

        return $validationRules;
    }
}
