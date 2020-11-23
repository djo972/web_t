<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoRequest extends FormRequest
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
            'themes' => 'required',
            'name' => 'required|max:255',
            'video_file' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'theme.required' => trans('formRequest.theme.required'),
            'name.required' => trans('formRequest.name.required'),
            //'link.required' => trans('formRequest.link.required'),
            'video_file.required' => trans('formRequest.video_file.required'),
        ];
    }
}
