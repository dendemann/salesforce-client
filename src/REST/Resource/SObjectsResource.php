<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\DTO;

/**
 * SObjectsResource
 */
class SObjectsResource extends AbstractResource implements ResourceInterface
{

    /**
     * @var string
     */
    const OBJECT_PATH = 'sobjects';

    /**
     * @return array
     */
    public function getAllObjects(): array
    {
        return $this->client->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH)
            )
        );
    }

    /**
     * @param string $object
     * @param \DateTimeInterface|null $since
     * @return array
     */
    public function getObjectMetadata(string $object, \DateTimeInterface $since = null): array
    {
        $headers = [];
        if ($since) {
            $headers['IF-Modified-Since'] = $since->format('D, j M Y H:i:s e');
        }

        return $this->client->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object),
                $headers
            )
        );
    }

    /**
     * @param string $object
     * @param \DateTimeInterface|null $since
     * @return array
     */
    public function describeObjectMetadata(string $object, \DateTimeInterface $since = null): array
    {
        $headers = [];
        if ($since) {
            $headers['IF-Modified-Since'] = $since->format('D, j M Y H:i:s e');
        }

        return $this->client->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object . '/describe'),
                $headers
            )
        );
    }

    /**
     * @param string $object
     * @param array $data
     * @return DTO\SalesforceObjectCreation
     */
    public function createObject(string $object, array $data): DTO\SalesforceObjectCreation
    {
        $data = $this->client->doAuthenticatedRequest(
            new Request(
                'POST',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object),
                ['content-type' => 'application/json'],
                json_encode($data)
            )
        );

        return DTO\SalesforceObjectCreation::createFromArray($data);
    }

    /**
     * @param string $object
     * @param string $id
     * @param array $data
     */
    public function patchObject(string $object, string $id, array $data): void
    {
        $this->client->doAuthenticatedRequest(
            new Request(
                'PATCH',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object . '/' . $id),
                ['content-type' => 'application/json'],
                json_encode($data)
            )
        );
    }

    /**
     * @param string $object
     * @param string $id
     */
    public function deleteObject(string $object, string $id): void
    {
        $this->client->doAuthenticatedRequest(
            new Request(
                'DELETE',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object . '/' . $id)
            )
        );
    }

    /**
     * @param string $object
     * @param string $id
     * @param array $fields
     * @return DTO\SalesforceObject
     */
    public function getObject(string $object, string $id, array $fields = []): DTO\SalesforceObject
    {
        $url = $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object . '/' . $id);

        if (false === empty($fields)) {
            $url .= '?fields=' . implode(',', $fields);
        }

        return DTO\SalesforceObject::createFromArray(
            $this->client->doAuthenticatedRequest(new Request('GET', $url))
        );
    }

}