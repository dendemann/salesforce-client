<?php

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * SalesforceObject.
 *
 * @author Stephane PY <s.py@wakeonweb.com>
 */
class SalesforceObjectCreation
{
    private $id;
    private $success;
    private $errors = [];
    private $warnings = [];

    private function __construct(string $id, bool $success, array $errors = [], array $warnings = [])
    {
        $this->id = $id;
        $this->success = $success;
        $this->errors = $errors;
        $this->warnings = $warnings;
    }

    public static function createFromArray(array $data)
    {
        return new self(
            (string) $data['id'],
            (bool) $data['success'],
            array_key_exists('errors', $data) ? (array) $data['errors'] : [],
            array_key_exists('warnings', $data) ? (array) $data['warnings'] : []
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getWarnings()
    {
        return $this->warnings;
    }
}
