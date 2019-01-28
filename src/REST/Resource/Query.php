<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\DTO;

/**
 * Query
 */
class Query extends AbstractResource implements ResourceInterface
{

    /**
     * @var string
     */
    protected $queryMethod = 'query';

    public function searchSOQL(string $query): DTO\SalesforceObjectResults
    {
        $url = $this->client->getGateway()->getServiceDataUrl($this->queryMethod) . '?q=' . $query;

        return DTO\SalesforceObjectResults::createFromArray(
            $this->client->doAuthenticatedRequest(
                new Request('GET', $url)
            )
        );
    }

    public function explainSOQL(string $query): array
    {
        $url = $this->client->getGateway()->getServiceDataUrl($this->queryMethod) . '?explain=' . $query;

        return $this->client->doAuthenticatedRequest(
            new Request('GET', $url)
        );
    }

}