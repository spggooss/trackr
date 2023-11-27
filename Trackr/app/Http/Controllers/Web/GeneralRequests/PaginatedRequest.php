<?php

namespace App\Http\Controllers\Web\GeneralRequests;

class PaginatedRequest extends Request
{
    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->query('page', 1);
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->query('limit', 20);
    }

    public function rules()
    {
        return [];
    }
}
