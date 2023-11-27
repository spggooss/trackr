<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $rating
 * @property string $comment
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
    ];
}
