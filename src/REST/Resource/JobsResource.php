<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\DTO;

/**
 * JobsResource
 */
class JobsResource extends AbstractResource implements ResourceInterface
{

    /**
     * @var string
     */
    const RESOURCE_PATH = 'jobs/ingest/';

    /**
     * @var string
     */
    const JOB_STATE_UPLOAD_COMPLETE = 'UploadComplete';

    /**
     * @var string
     */
    const JOB_STATE_ABORTED = 'Aborted';

    /**
     * @param array $data
     * @return DTO\JobCreation
     */
    public function createJob(array $data = []): DTO\JobCreation
    {

        $data = $this->client->doAuthenticatedRequest(
            new Request(
                'POST',
                $this->client->getGateway()->getServiceDataUrl(static::RESOURCE_PATH),
                ['content-type' => 'application/json'],
                json_encode($data)
            )
        );

        return DTO\JobCreation::createFromArray($data);

    }

    /**
     * @param string $jobId
     */
    public function deleteJob(string $jobId): void
    {

        $this->client->doAuthenticatedRequest(
            new Request(
                'DELETE',
                $this->client->getGateway()->getServiceDataUrl(static::RESOURCE_PATH . $jobId)
            )
        );

    }

    /**
     * @param string $jobId
     * @param string $state
     * @return DTO\JobCreation
     */
    public function cancelJob(string $jobId, string $state): DTO\JobCreation
    {

        $data = $this->client->doAuthenticatedRequest(
            new Request(
                'PATCH',
                $this->client->getGateway()->getServiceDataUrl(static::RESOURCE_PATH . $jobId),
                ['content-type' => 'application/json'],
                json_encode([
                    'state' => $state
                ])
            )
        );

        return DTO\JobCreation::createFromArray($data);

    }

    /**
     * @param string $jobId
     * @return DTO\JobCreation
     */
    public function abortJob(string $jobId): DTO\JobCreation
    {
        return $this->cancelJob($jobId, static::JOB_STATE_ABORTED);
    }

    /**
     * @param string $jobId
     * @return DTO\JobCreation
     */
    public function closeJob(string $jobId): DTO\JobCreation
    {
        return $this->cancelJob($jobId, static::JOB_STATE_UPLOAD_COMPLETE);
    }

    /**
     * @param string $jobId
     * @param string|null|resource|\Psr\Http\Message\StreamInterface $body
     */
    public function uploadJobData(string $jobId, $body)
    {

        $this->client->doAuthenticatedRequest(
            new Request(
                'PUT',
                $this->client->getGateway()->getServiceDataUrl(static::RESOURCE_PATH . $jobId . '/batches'),
                ['content-type' => 'text/csv'],
                $body
            )
        );

    }

}