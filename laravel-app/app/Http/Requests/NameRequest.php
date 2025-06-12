<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NameRequest extends FormRequest
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
            'userName' => 'required|string|min:3|max:50',
        ];
    }

    
    public function validationData()
    {
        return array_merge($this->all(), [
            'userName' => $this->route('userName'),
        ]);
    }

    public function messages()
    {
        return [
            'userName.required' => 'userName is required.',
            'userName.min' => 'The username must be at least :min characters long.',
            'userName.max' => 'The username cannot have more than :max characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }

}
