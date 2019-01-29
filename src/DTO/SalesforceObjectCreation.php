<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * SalesforceObject.
 *
 * @author Stephane PY <s.py@wakeonweb.com>
 */
class SalesforceObjectCreation
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var bool
     */
    private $success;

    /**
     * @var array
     */
    private $errors = [];

    /**
     * @var array
     */
    private $warnings = [];

    /**
     * Constructor
     *
     * @param string $id
     * @param bool $success
     * @param array $errors
     * @param array $warnings
     */
    private function __construct(string $id, bool $success, array $errors = [], array $warnings = [])
    {
        $this->id = $id;
        $this->success = $success;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    /**
     * @param array $data
     * @return SalesforceObjectCreation
     */
    public static function createFromArray(array $data): SalesforceObjectCreation
    {
        return new self(
            (string) $data['id'],
            (bool) $data['success'],
            array_key_exists('errors', $data) ? (array) $data['errors'] : [],
            array_key_exists('warnings', $data) ? (array) $data['warnings'] : []
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

}
