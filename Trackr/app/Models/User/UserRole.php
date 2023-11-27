<?php

namespace App\Models\User;


use App\Support\Enumeration;

class UserRole extends Enumeration
{
    public const SUPER_ADMIN = 'super_admin';
    public const WEB_SHOP_ADMIN = 'webshop_admin';
    public const PACKAGE_HANDLER = 'package_handler';
    public const EDITOR = 'editor';
    public const USER = 'user';

    /**
     * Returns all valid enumeration values
     * @return array
     */
    public static function getAll()
    {
        return [
            self::WEB_SHOP_ADMIN,
            self::SUPER_ADMIN,
            self::EDITOR,
            self::PACKAGE_HANDLER,
            self::USER,
        ];
    }

    public static function getAllWebshop()
    {
        return [
            self::WEB_SHOP_ADMIN,
            self::EDITOR,
            self::PACKAGE_HANDLER,
        ];
    }

    public function getValue()
    {
        return $this->value;
    }

    public function i18n()
    {
        return __('enumerations.user-type.' . $this->value);
    }
}
