<?php

namespace App\Models\User;

use App\Models\Webshop\Webshop;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentUsersRepository implements UsersRepository
{
    /**
     * @return User[]
     */
    public function all(): array
    {
        return User::all()->all();
    }

    /**
     * @param User $user
     * @return void
     */
    public function store(User $user)
    {
        $user->save();
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return User::where('id', $id)->first();
    }

    /**
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPaged(int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', ?string $searchTerm = null): LengthAwarePaginator
    {
        if ($searchTerm !== null) {
            $builder = User::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            $builder->orderBy($orderBy, $orderDirection);
        } else {
            $builder = User::orderBy($orderBy, $orderDirection);
        }

        return $builder->paginate($limit, ['*'], 'page', $page);
    }

    /**
     * @param Webshop $webshop
     * @param int $page
     * @param int $limit
     * @param string|null $orderBy
     * @param string|null $orderDirection
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getPagedForWebshop(Webshop $webshop, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', ?string $searchTerm = null): LengthAwarePaginator
    {
        $builder = User::where('webshop_id', $webshop->id);

        if ($searchTerm !== null && $searchTerm !== '') {
            $builder->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $builder = $builder->orderBy($orderBy, $orderDirection);

        return $builder->paginate($limit, ['*'], 'page', $page);
    }
}
