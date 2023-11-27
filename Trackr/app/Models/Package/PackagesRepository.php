<?php

namespace App\Models\Package;

use App\Models\Webshop\Webshop;
use Illuminate\Pagination\LengthAwarePaginator;

interface PackagesRepository
{
    /**
     * @return Package[]
     */
    public function all(): array;

    public function getAllForWebshop($webshopId): array;

    /**
     * @param Package $package
     * @return Package
     */
    public function store(Package $package): Package;

    /**
     * @param int $id
     * @return Package|null
     */
    public function findById(int $id, array $relations): ?Package;

    /**
     * @param string $traceCode
     * @param string $postalCode
     * @return Package|null
     */
    public function findByTraceCodeAndPostalCode(string $traceCode, string $postalCode): ?Package;

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

    /**
     * @param $user
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @return LengthAwarePaginator
     */
    public function getPagedForUser(
        $user, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc'
    ): LengthAwarePaginator;

    /**
     * @param Webshop $webshop
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPagedForWebshop(Webshop $webshop, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', string $searchTerm = null
    ): LengthAwarePaginator;
}
