<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * JobCreation
 */
class JobCreation
{

    use FieldAccessTrait;

    /**
     * Constructor
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    public static function createFromArray(array $data)
    {
        return new self($data);
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->getField('id');
    }

    /**
     * @return string|null
     */
    public function getContentUrl()
    {
        return $this->getField('contentUrl');
    }

    /**
     * @return string|null
     */
    public function getState()
    {
        return $this->getField('state');
    }

}