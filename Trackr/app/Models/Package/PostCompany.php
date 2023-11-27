<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 */
class PostCompany extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    protected $casts = [
        'id' => 'integer',
    ];
}
