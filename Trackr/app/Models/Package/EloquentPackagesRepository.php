<?php

namespace App\Models\Package;

use App\Models\Webshop\Webshop;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentPackagesRepository implements PackagesRepository
{
    /**
     * @return Package[]
     */
    public function all(): array
    {
        return Package::all()->all();
    }

    public function getAllForWebshop($webshopId): array
    {
        return Package::where('webshop_id', $webshopId)->get()->all();
    }

    /**
     * @param Package $package
     * @return Package
     */
    public function store(Package $package): Package
    {
        $package->save();
        return $package;
    }

    /**
     * @param int $id
     * @param array $relations
     * @return Package|null
     */
    public function findById(int $id, array $relations = []): ?Package
    {
        $builder = Package::where('id', $id);

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
    public function getPaged(int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', string $searchTerm = null): LengthAwarePaginator
    {
        if ($searchTerm !== null) {
            $builder = Package::whereHas('pickupAddress', function ($query) use ($searchTerm) {
                $query->whereRaw("MATCH(street_name, house_number, postal_code, city, country) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
            })->orWhereHas('dropoffAddress', function ($query) use ($searchTerm) {
                $query->whereRaw("MATCH(street_name, house_number, postal_code, city, country) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
            });
            $builder = $builder->orWhere('trace_code', 'LIKE', '%' . $searchTerm . '%');
            $builder->orderBy($orderBy, $orderDirection);
        } else {
            $builder = Package::orderBy($orderBy, $orderDirection);
        }

        return $builder->paginate($limit, ['*'], 'page', $page);
    }

    public function findByTraceCodeAndPostalCode(string $traceCode, string $postalCode): ?Package
    {
        return Package::where('trace_code', $traceCode)
            ->whereHas('dropoff_address', function ($query) use ($postalCode) {
                $query->where('postal_code', $postalCode);
            })
            ->first();
    }

    public function getPagedForUser($user, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc'): LengthAwarePaginator
    {
        $builder = Package::where('user_id', $user->id);

        $builder = $builder->orderBy($orderBy, $orderDirection);

        return $builder->paginate($limit, ['*'], 'page', $page);
    }

    public function getPagedForWebshop(Webshop $webshop, int $page, int $limit, ?string $orderBy = 'id', ?string $orderDirection = 'asc', ?string $searchTerm = null): LengthAwarePaginator
    {
        $webshopId = json_decode($webshop)->id;

        if ($searchTerm !== null) {
            $builder = Package::where('webshop_id', $webshopId)
                ->whereHas('pickupAddress', function ($query) use ($searchTerm) {
                    $query->whereRaw("MATCH(street_name, house_number, postal_code, city, country) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
                })->orWhereHas('dropoffAddress', function ($query) use ($searchTerm) {
                    $query->whereRaw("MATCH(street_name, house_number, postal_code, city, country) AGAINST(? IN BOOLEAN MODE)", [$searchTerm]);
                })->orWhere('trace_code', 'LIKE', '%' . $searchTerm . '%');
            $builder->orderBy($orderBy, $orderDirection);
        } else {
            $builder = Package::where('webshop_id', $webshopId);
        }
        $builder = $builder->orderBy($orderBy, $orderDirection);

        return $builder->paginate($limit, ['*'], 'page', $page);
    }
}
