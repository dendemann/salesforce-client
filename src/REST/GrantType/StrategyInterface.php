<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\GrantType;

use WakeOnWeb\SalesforceClient\REST\Gateway;

interface StrategyInterface
{

    /**
     * @param Gateway $gateway
     * @return string
     */
    public function buildAccessToken(Gateway $gateway): string;

}
