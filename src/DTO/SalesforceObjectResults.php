<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\DTO;

/**
 * SalesforceObjectResults.
 *
 * @author Stephane PY <s.py@wakeonweb.com>
 */
class SalesforceObjectResults
{

    /**
     * @var int
     */
    private $totalSize;

    /**
     * @var bool
     */
    private $done;

    /**
     * @var array
     */
    private $records = [];

    private function __construct(int $totalSize, bool $done, array $records)
    {
        $this->totalSize = $totalSize;
        $this->done = $done;
        foreach ($records as $record) {
            $this->addRecord($record);
        }
    }

    /**
     * @param SalesforceObject $record
     */
    private function addRecord(SalesforceObject $record): void
    {
        $this->records[] = $record;
    }

    /**
     * @param array $data
     * @return SalesforceObjectResults
     */
    public static function createFromArray(array $data): self
    {
        $records = [];
        foreach ($data['records'] as $record) {
            $records[] = SalesforceObject::createFromArray($record);
        }

        return new self(
            (int) $data['totalSize'],
            (bool) $data['done'],
            $records
        );
    }

    /**
     * @return int
     */
    public function getTotalSize(): int
    {
        return $this->totalSize;
    }

    /**
     * @return bool
     */
    public function isDone(): bool
    {
        return $this->done;
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        return $this->records;
    }

}
