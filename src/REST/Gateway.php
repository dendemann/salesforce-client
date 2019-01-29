<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST;

class Gateway
{

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var string
     */
    private $version;

    /**
     * Constructor
     *
     * @param string $endpoint
     * @param string $version
     */
    public function __construct(string $endpoint, string $version)
    {
        $this->endpoint = $endpoint;
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string|null $path
     * @return string
     */
    public function getServiceDataUrl(string $path = null): string
    {
        return $this->endpoint . '/services/data/v' . $this->version . '/' . $path;
    }
}
