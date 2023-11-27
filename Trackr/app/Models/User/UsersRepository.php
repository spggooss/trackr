<?php

namespace App\Models\User;

use App\Models\Webshop\Webshop;
use Illuminate\Pagination\LengthAwarePaginator;

interface UsersRepository
{
    /**
     * @return User[]
     */
    public function all();

    /**
     * @param User $user
     * @return User
     */
    public function store(User $user);

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

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

    /**
     * @param Webshop $webshop
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPagedForWebshop(
        Webshop $webshop, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', ?string $searchTerm = null
    ): LengthAwarePaginator;
}
