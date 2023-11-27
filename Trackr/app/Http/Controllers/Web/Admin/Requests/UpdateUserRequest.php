<?php

namespace App\Http\Controllers\Web\Admin\Requests;

use App\Models\User\UserRole;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string',
            'webshop_id' => 'nullable|exists:webshops,id',
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

    public function getWebshopId()
    {
        return $this->get('webshop_id');
    }

    public function getRole(): UserRole
    {
        return UserRole::create($this->get('role'));
    }
}
