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
        ResourceInterface::RESOURCE_SOBJECTS => SObjects::class,
        ResourceInterface::RESOURCE_QUERY => Query::class,
        ResourceInterface::RESOURCE_QUERY_ALL => QueryAll::class,
        ResourceInterface::RESOURCE_JOBS => Jobs::class
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