<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindPackageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'trace_code' => 'required|string',
            'postal_code' => 'required|string',
        ];
    }

    public function getTraceCode()
    {
        return $this->get('trace_code');
    }

    public function getPostalCode()
    {
        return $this->get('postal_code');
    }
}
