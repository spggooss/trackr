<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPackageToAccountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'packageId' => 'required|numeric',
            'email' => 'required|string',
        ];
    }

    public function getPackageId()
    {
        return $this->get('packageId');
    }

    public function getEmail()
    {
        return $this->get('email');
    }
}
