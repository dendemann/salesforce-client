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

    /**
     * @param array $data
     * @return JobCreation
     */
    public static function createFromArray(array $data): self
    {
        return new self($data);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->getField('id');
    }

    /**
     * @return string|null
     */
    public function getContentUrl(): ?string
    {
        return $this->getField('contentUrl');
    }

    /**
     * @return string|null
     */
    public function getState(): ?string
    {
        return $this->getField('state');
    }

}