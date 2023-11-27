<?php

namespace App\Support;

use App\Support\Exceptions\InvalidEnumerationException;

abstract class Enumeration implements \JsonSerializable
{
    /**
     * Contains singleton instances of all enums
     * @var array
     */
    private static $instances = [];

    /**
     * The internal value from which the enum is created
     * @var string
     */
    protected $value;

    /**
     * Enumeration constructor.
     * @param string $value
     * @throws InvalidEnumerationException
     */
    final private function __construct(string $value)
    {
        if (!in_array($value, $this->getAll())) {
            throw new InvalidEnumerationException(
                'Trying to instantiate ' . get_called_class() . ' with unknown value "' . $value . '"'
            );
        }
        $this->value = $value;
    }

    /**
     * Returns all valid enumeration values
     * @return array
     */
    abstract public static function getAll();

    /**
     * Use this method to create an instance
     * @param string $value
     * @return static
     */
    final public static function create(string $value)
    {
        $calledClass = static::class;

        $key = $calledClass . ' - ' . $value;
        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new $calledClass($value);
        }

        return self::$instances[$key];
    }

    /**
     * When you want to serialize it
     * @return string
     */
    final public function __toString()
    {
        return $this->value;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->value;
    }

    public function __sleep()
    {
        return ['value'];
    }

    /**
     * Returns the value of an enumeration
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string|array $type
     * @return bool
     */
    public function is($type): bool
    {
        if (is_array($type)) {
            foreach ($type as $t) {
                if ((string) $t === $this->value) {
                    return true;
                }
            }
            return false;
        }

        return (string) $type === $this->value;
    }

    /**
     * @param string|array $type
     * @return bool
     */
    public function isNot($type): bool
    {
        return !$this->is($type);
    }
}
