<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use WakeOnWeb\SalesforceClient\ClientInterface;
use WakeOnWeb\SalesforceClient\Exception;
use WakeOnWeb\SalesforceClient\Exception\SalesforceClientException;
use WakeOnWeb\SalesforceClient\REST\GrantType\StrategyInterface as GrantTypeStrategyInterface;
use WakeOnWeb\SalesforceClient\REST\Resource\ResourceFactory;
use WakeOnWeb\SalesforceClient\REST\Resource\ResourceInterface;

class Client implements ClientInterface
{

    /**
     * @var Gateway
     */
    private $gateway;

    /**
     * @var GrantTypeStrategyInterface
     */
    private $grantTypeStrategy;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var ResourceFactory
     */
    private $resourceFactory;

    /**
     * Constructor
     *
     * @param Gateway $gateway
     * @param GrantTypeStrategyInterface $grantTypeStrategy
     * @param HttpClient|null $httpClient
     */
    public function __construct(
        Gateway $gateway,
        GrantTypeStrategyInterface $grantTypeStrategy,
        HttpClient $httpClient = null
    ) {
        $this->gateway = $gateway;
        $this->grantTypeStrategy = $grantTypeStrategy;
        $this->httpClient = $httpClient ?: new HttpClient();
        $this->resourceFactory = new ResourceFactory($this);
    }

    /**
     * @return array
     */
    public function getAvailableResources(): array
    {
        return $this->doAuthenticatedRequest(
            new Request(
                'GET',
                $this->gateway->getServiceDataUrl()
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function getGateway(): Gateway
    {
        return $this->gateway;
    }

    /**
     * @inheritdoc
     */
    public function getResource(string $resourceName): ResourceInterface
    {
        return $this->resourceFactory->createInstance($resourceName);
    }

    /**
     * @inheritdoc
     */
    public function doAuthenticatedRequest(Request $request)
    {
        $this->connectIfAccessTokenIsEmpty();

        $request = $request->withAddedHeader('Authorization', 'Bearer ' . $this->accessToken);

        try {
            $response = $this->httpClient->send($request);
        } catch (RequestException $e) {
            throw Exception\ExceptionFactory::generateFromRequestException($e);
        } catch (\Exception $e) {
            throw new SalesforceClientException($e->getMessage(), 0, $e);
        }

        $body = '[]';

        // Check if response has content
        if ($response->getStatusCode() !== 204) {
            $body = (string)$response->getBody();
        }

        return json_decode($body, true);
    }


    private function connectIfAccessTokenIsEmpty(): void
    {
        if (null !== $this->accessToken) {
            return;
        }

        $this->accessToken = $this->grantTypeStrategy->buildAccessToken($this->gateway);
    }
}
