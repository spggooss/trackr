<?php

namespace App\Models\Package;

use Illuminate\Pagination\LengthAwarePaginator;

interface PostCompanyRepository
{
    /**
     * @return PostCompany[]
     */
    public function all(): array;

    /**
     * @param PostCompany $postCompany
     * @return PostCompany
     */
    public function store(PostCompany $postCompany): PostCompany;

    /**
     * @param int $id
     * @return PostCompany|null
     */
    public function findById(int $id, array $relations): ?PostCompany;

    /**
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPaged(
        int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', string $searchTerm = null
    ): LengthAwarePaginator;
}
