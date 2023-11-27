<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(){
        return [
            'search_term' => 'nullable|string',
        ];
    }

    public function getSearchTerm(): ?string
    {
        return $this->input('search_term');
    }

}
