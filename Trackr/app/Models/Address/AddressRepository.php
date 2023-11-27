<?php

namespace App\Models\Address;

use Illuminate\Pagination\LengthAwarePaginator;

interface AddressRepository
{
    /**
     * @return Address[]
     */
    public function all(): array;

    /**
     * @param Address $address
     * @return Address
     */
    public function store(Address $address): Address;

    /**
     * @param int $id
     * @return Address|null
     */
    public function findById(int $id): ?Address;

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
