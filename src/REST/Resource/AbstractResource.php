<?php

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use WakeOnWeb\SalesforceClient\ClientInterface;

/**
 * AbstractResource
 */
abstract class AbstractResource
{

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * Constructor
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

}