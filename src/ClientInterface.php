<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient;

use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\REST\Gateway;
use WakeOnWeb\SalesforceClient\REST\Resource\ResourceInterface;

interface ClientInterface
{

    /**
     * @return Gateway
     */
    public function getGateway(): Gateway;

    /**
     * @param string $resourceName
     * @return ResourceInterface
     */
    public function getResource(string $resourceName): ResourceInterface;

        /**
     * @param Request $request
     * @return mixed
     */
    public function doAuthenticatedRequest(Request $request);

}
