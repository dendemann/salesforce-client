<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use WakeOnWeb\SalesforceClient\REST\Client;

/**
 * ResourceFactory
 */
class ResourceFactory
{

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string[]
     */
    const CLASSMAP = [
        ResourceInterface::RESOURCE_SOBJECTS => SObjectsResource::class,
        ResourceInterface::RESOURCE_QUERY => QueryResource::class,
        ResourceInterface::RESOURCE_QUERY_ALL => QueryAllResource::class,
        ResourceInterface::RESOURCE_JOBS => JobsResource::class
    ];

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $resourceName
     * @return ResourceInterface
     * @throws \Exception
     */
    public function createInstance(string $resourceName): ResourceInterface
    {

        $class = self::CLASSMAP[$resourceName] ?? null;

        if ($class === null) {
            throw new \Exception('Resource with the name "' . $resourceName . '" could not be instantiated');
        }

        return new $class($this->client);

    }

}