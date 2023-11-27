<?php

namespace App\Models\Webshop;

use Illuminate\Pagination\LengthAwarePaginator;

interface WebshopsRepository
{
    /**
     * @return Webshop[]
     */
    public function all();

    /**
     * @param Webshop $webshop
     * @return Webshop
     */
    public function store(Webshop $webshop);

    /**
     * @param string $name
     * @return Webshop|null
     */
    public function findByName(string $name): ?Webshop;

    /**
     * @param int $id
     * @return Webshop|null
     */
    public function findById(int $id): ?Webshop;

    /**
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPaged(
        int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', ?string $searchTerm = null
    ): LengthAwarePaginator;
}
