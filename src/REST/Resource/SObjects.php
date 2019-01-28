<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\ClientInterface;
use WakeOnWeb\SalesforceClient\DTO;

/**
 * SObjects
 */
class SObjects implements ResourceInterface
{

    /**
     * @var string
     */
    const OBJECT_PATH = 'sobjects';

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * Constructor
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getAllObjects(): array
    {
        return $this->client->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH)
            )
        );
    }

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

    public function patchObject(string $object, string $id, array $data)
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

    public function deleteObject(string $object, string $id)
    {
        $this->client->doAuthenticatedRequest(
            new Request(
                'DELETE',
                $this->client->getGateway()->getServiceDataUrl(static::OBJECT_PATH . '/' . $object . '/' . $id)
            )
        );
    }

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