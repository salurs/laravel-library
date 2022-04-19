<?php

namespace App\Http\Requests;

use App\Helper\ResponseBuilder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddressCreateRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'city' => [
                'required',
                Rule::in(['İSTANBUL', 'ANKARA', 'İZMİR']),
                Rule::unique('addresses')->where('address', $this->address)->where('user_id', $this->user_id)
            ],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'city.unique' => 'Invalid address'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseBuilder::apiResponse(status: false, message: 'Validation error', errors: $validator->errors()->toArray(), code: 422));
    }
}
