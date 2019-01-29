<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * FieldAccessTrait
 */
trait FieldAccessTrait
{

    /**
     * @var array
     */
    private $fields = [];

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getField(string $key, $default = null)
    {
        return $this->hasField($key) ? $this->fields[$key] : $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasField(string $key): bool
    {
        return array_key_exists($key, $this->fields);
    }

}