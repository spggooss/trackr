<?php

namespace App\Models\Address;

use App\Models\Package\Package;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $street_name
 * @property string $house_number
 * @property string $postal_code
 * @property string $city
 * @property string $country
 * @property string $full_address
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street_name',
        'house_number',
        'postal_code',
        'city',
        'country',
    ];

    // Relationships
    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }

    public function getFullAddressAttribute(): string
    {
        return "$this->street_name $this->house_number, $this->postal_code $this->city, $this->country";
    }
}
