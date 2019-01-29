<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * SalesforceObject.
 *
 * @author Stephane PY <s.py@wakeonweb.com>
 */
class SalesforceObject
{

    use FieldAccessTrait;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * Constructor
     *
     * @param array $attributes
     * @param array $fields
     */
    private function __construct(array $attributes, array $fields)
    {
        $this->attributes = $attributes;
        $this->fields = $fields;
    }

    /**
     * @param array $data
     * @return SalesforceObject
     */
    public static function createFromArray(array $data): SalesforceObject
    {
        $attributes = array_key_exists('attributes', $data) ? (array) $data['attributes'] : [];
        unset($data['attributes']);

        return new self($attributes, $data);

    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->getAttribute('type');
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->getAttribute('url');
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute(string $key, $default = null)
    {
        return $this->hasAttribute($key) ? $this->attributes[$key] : $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasAttribute(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

}
