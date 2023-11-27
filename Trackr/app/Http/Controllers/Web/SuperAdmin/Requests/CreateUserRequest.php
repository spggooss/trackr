<?php

namespace App\Http\Controllers\Web\SuperAdmin\Requests;

use App\Models\User\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'webshop_id' => 'nullable|string',
            'remember_token' => 'nullable|string',
            'role' => 'required|in:' . implode(',', UserRole::getAll()),
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

    public function getEmail()
    {
        return $this->get('email');
    }

    public function getPassword(): ?string
    {
        return $this->get('password');
    }
}
