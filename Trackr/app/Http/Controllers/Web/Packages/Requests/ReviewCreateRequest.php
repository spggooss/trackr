<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'packageId' => 'required|numeric',
            'rating' => 'required|numeric',
            'comment' => 'string',
        ];
    }

    public function getPackageId()
    {
        return $this->get('packageId');
    }

    public function getRating()
    {
        return $this->get('rating');
    }

    public function getComment()
    {
        return $this->get('comment');
    }
}
