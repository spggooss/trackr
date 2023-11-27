<?php

namespace App\Models\Package;

use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPostCompanyRepository implements PostCompanyRepository
{
    /**
     * @return PostCompany[]
     */
    public function all(): array {
        return PostCompany::all()->all();
    }

    /**
     * @param PostCompany $postCompany
     * @return PostCompany
     */
    public function store(PostCompany $postCompany): PostCompany {
        $postCompany->save();
        return $postCompany;
    }

    /**
     * @param int $id
     * @return PostCompany|null
     */
    public function findById(int $id, array $relations = []): ?PostCompany {
        $builder = PostCompany::where('id', $id);

        if (!empty($relations)) {
            $builder = $builder->with($relations);
        }

        return $builder->first();
    }

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
    ): LengthAwarePaginator {
        if ($searchTerm !== null) {
            $builder = PostCompany::where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('price', 'LIKE', '%' . $searchTerm . '%');

            $builder->orderBy($orderBy, $orderDirection);
        } else {
            $builder = PostCompany::orderBy($orderBy, $orderDirection);
        }

        return $builder->paginate($limit, ['*'], 'page', $page);
    }
}
