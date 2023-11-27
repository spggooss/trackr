<?php

namespace App\Http\Controllers\Api\Requests;

use App\Models\Package\PackageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiPackageUpdateStatusRequest extends FormRequest
{
    public function rules(){
        return [
            'status' => 'required|in:' . implode(',', PackageStatus::getAll()),
        ];

    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();

        $response = [
            'message' => 'The given data was invalid.',
            'errors' => $errors,
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }

    public function getStatus(){
        return $this->get('status');
    }


}
