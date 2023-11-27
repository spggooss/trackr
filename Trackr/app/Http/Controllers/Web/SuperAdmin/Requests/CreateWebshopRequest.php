<?php

namespace App\Http\Controllers\Web\SuperAdmin\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateWebshopRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = [
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }
    public function getName()
    {
        return $this->get('name');
    }

}
