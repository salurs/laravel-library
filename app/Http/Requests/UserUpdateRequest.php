<?php

namespace App\Http\Requests;

use App\Helper\ResponseBuilder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required','email',Rule::unique('users')->ignore($this->user->id)]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseBuilder::apiResponse(status: false, message: 'Validation error', errors: $validator->errors()->toArray(), code: 422));
    }
}
