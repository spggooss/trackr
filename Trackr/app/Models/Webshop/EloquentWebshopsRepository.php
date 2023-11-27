<?php

namespace App\Models\Webshop;

use Illuminate\Pagination\LengthAwarePaginator;

class EloquentWebshopsRepository implements WebshopsRepository
{
    /**
     * @return Webshop[]
     */
    public function all(): array
    {
        return Webshop::all()->all();
    }

    /**
     * @param Webshop $webshop
     * @return void
     */
    public function store(Webshop $webshop)
    {
        $webshop->save();
    }

    /**
     * @param string $name
     * @return Webshop|null
     */
    public function findByName(string $name): ?Webshop
    {
        return Webshop::where('name', $name)->first();
    }

    /**
     * @param int $id
     * @return Webshop|null
     */
    public function findById(int $id): ?Webshop
    {
        return Webshop::where('id', $id)->first();
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
            $builder = Webshop::where('name', 'LIKE', '%' . $searchTerm . '%');
            $builder->orderBy($orderBy, $orderDirection);
        } else {
            $builder = Webshop::orderBy($orderBy, $orderDirection);
        }

        return $builder->paginate($limit, ['*'], 'page', $page);
    }

}
