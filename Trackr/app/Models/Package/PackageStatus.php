<?php

namespace App\Models\Package;


use App\Support\Enumeration;

class PackageStatus extends Enumeration
{
    public const REGISTERED = 'registered';
    public const PRINTED = 'printed';
    public const PICKED_UP = 'picked_up';

    public const SORTING_CENTER = 'sorting_center';


    public const IN_TRANSIT = 'in_transit';

    public const DELIVERED = 'delivered';

    /**
     * Returns all valid enumeration values
     * @return array
     */
    public static function getAll()
    {
        return [
           self::REGISTERED,
           self::PRINTED,
           self::PICKED_UP,
           self::SORTING_CENTER,
           self::IN_TRANSIT,
           self::DELIVERED,

        ];
    }

    public function getValue()
    {
        return $this->value;
    }

    public function i18n()
    {
        return __('enumerations.package-status.' . $this->value);
    }

}
