<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBrakerRequest extends FormRequest
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
            'preview' => 'required|image|max:1000|mimes:jpeg,png',
            'video_file' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('formRequest.name.required'),
            'preview.required' => trans('formRequest.preview.required'),
            'video_file.required' => trans('formRequest.video_file.required'),
        ];
    }
}
