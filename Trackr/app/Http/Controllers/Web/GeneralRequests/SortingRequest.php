<?php

namespace App\Http\Controllers\Web\GeneralRequests;

use Illuminate\Support\Str;

class SortingRequest extends Request
{
    public function getSort()
    {
        return $this->query('sort', '');
    }

    public function rules()
    {
        return [];
    }

    public function getOrderBy()
    {
        if ($this->getSort() === '') {
            return null;
        }
        return Str::before($this->getSort(), ':');
    }

    public function getOrderDirection()
    {
        if ($this->getSort() === '') {
            return null;
        }

        return Str::after($this->getSort(), ':');
    }

    public function getSearchTerm()
    {
        return $this->query('search', '');
    }
}
