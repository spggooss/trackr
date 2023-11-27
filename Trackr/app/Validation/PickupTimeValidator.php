<?php

namespace App\Validation;

use Carbon\Carbon;

class PickupTimeValidator
{
    /**
     * @param string $attribute
     * @param string|null $value
     * @param array|null $parameters
     * @param mixed $validator
     * @return bool
     */
    public function validate(string $attribute, ?string $value, ?array $parameters, $validator): bool
    {
        $valid = true;
        $currentTime = Carbon::now()->setTimezone('Europe/Amsterdam');
        $pickupDate = Carbon::parse($value);
        if ($currentTime->hour >= 15 && $pickupDate->diffInDays($currentTime->copy()->addDays(3), false) > 0) {
            $validator->errors()->add(
                $attribute,
                __('validation.pickup_time_after_15')
            );
            return false;
        }
        if ($currentTime->hour < 15 && $pickupDate->diffInDays($currentTime->copy()->addDays(2), false) > 0) {
            $validator->errors()->add(
                $attribute,
                __('validation.pickup_time_before_15')
            );
            return false;
        }



        return true;
    }

}
