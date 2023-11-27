<?php

namespace App\Models\Webshop;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Webshop  extends Model
{
    protected $fillable = [
        'name',
    ];

}
