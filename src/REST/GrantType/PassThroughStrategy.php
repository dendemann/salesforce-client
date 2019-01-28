<?php

namespace WakeOnWeb\SalesforceClient\REST\GrantType;

use WakeOnWeb\SalesforceClient\REST\Gateway;

/**
 * PassThroughStrategy
 */
class PassThroughStrategy implements StrategyInterface
{

    /**
     * @var string
     */
    private $accessToken;

    /**
     * Constructor
     *
     * @param string $accessToken
     */
    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @inheritdoc
     */
    public function buildAccessToken(Gateway $gateway): string
    {
        return $this->accessToken;
    }

}