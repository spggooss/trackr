<?php

namespace App\Models\Package;

use App\Models\Address\Address;
use App\Models\User\User;
use App\Models\Webshop\Webshop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string $name
 * @property string $email
 * @property PackageStatus $status
 * @property string $pickup_date
 * @property string $pickup_time
 * @property Address $pickup_address
 * @property Address $dropoff_address
 * @property User|null $user
 * @property string $trace_code
 * @property int|null $post_company_id
 * @property PostCompany|null $post_company
 * @property int|null $review_id
 * @property Carbon|null $pickupDateTime
 * @property Review|null $review
 * @property int $webshop_id
 * @property Webshop $webshop
 */
class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'pickup_date',
        'pickup_time',
        'trace_code',
        'name',
        'email',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pickup_address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'pickup_address_id');
    }

    public function dropoff_address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'dropoff_address_id');
    }

    public function post_company(): BelongsTo
    {
        return $this->belongsTo(PostCompany::class, 'post_company_id');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function webshop(): BelongsTo
    {
        return $this->belongsTo(Webshop::class);
    }

    public function assignWebshop(Webshop $webshop)
    {
        $this->webshop()->associate($webshop);
        $this->save();
    }

    public function assignDropOffAddress(Address $address)
    {
        $this->dropoff_address()->associate($address);
        $this->save();
    }

    public function getPickupDateTimeAttribute(): Carbon|null
    {
        if ($this->pickup_time !== null && $this->pickup_date !== null) {
            return Carbon::parse($this->pickup_date . $this->pickup_time);
        } else {
            return null;
        }
    }

    public function assignPickupAddress(Address $address)
    {
        $this->pickup_address()->associate($address);
        $this->save();
    }

    public function assignUser(User $user)
    {
        $this->user()->associate($user);
        $this->save();
    }

    public function assignPostCompany(PostCompany $postCompany)
    {
        $this->post_company()->associate($postCompany);
        $this->save();
    }

    public function assignReview(Review $review)
    {
        $this->review()->associate($review);
        $this->save();
    }
}
