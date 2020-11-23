<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrakerRequest extends FormRequest
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
            'name' => 'required|max:255',
            'video_file' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('formRequest.name.required'),
            'video_file.required' => trans('formRequest.video_file.required'),
        ];
    }
}
