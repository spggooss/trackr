<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateLabelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'packageId' => 'numeric',
            'packageIds' => 'array',
        ];
    }

    public function getPackageId() {
        return $this->get('packageId');
    }

    public function getPackageIds() {
        return $this->get('packageIds');
    }
}
