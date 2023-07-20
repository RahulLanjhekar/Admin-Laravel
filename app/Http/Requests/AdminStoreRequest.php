<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'title' => ['required','string', 'regex:/^[a-zA-Z ]*$/'],
            'description' => 'required|string|regex:/^[a-zA-Z ]*$/',
            'user_id' => 'required|integer'
            // 'password' => 'required'
        ];
    }

     /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'title is required!',
            'description.required' => 'description is required!',
            // 'password.required' => 'Password is required!'
        ];
    }
}