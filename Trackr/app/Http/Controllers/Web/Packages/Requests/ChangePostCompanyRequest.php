<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePostCompanyRequest extends FormRequest
{
    public function rules(){
        return [
            'post_company' => 'required|exists:post_companies,id',
        ];
    }
    public function getPostCompany(): int
    {
        return $this->get('post_company');
    }

}
