<?php

namespace App\Models\Address;

use Illuminate\Pagination\LengthAwarePaginator;

class EloquentAddressRepository implements AddressRepository
{
    /**
     * @return Address[]
     */
    public function all(): array
    {
        return Address::all()->all();
    }

    /**
     * @param Address $address
     * @return Address
     */
    public function store(Address $address): Address
    {
        $address->save();
        return $address;
    }

    /**
     * @param int $id
     * @return Address|null
     */
    public function findById(int $id): ?Address
    {
        return Address::where('id', $id)->first();
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
        $builder = Address::orderBy($orderBy, $orderDirection);

        return $builder->paginate($limit, ['*'], 'page', $page);
    }
}
