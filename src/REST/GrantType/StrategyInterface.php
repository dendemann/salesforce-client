<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\GrantType;

use WakeOnWeb\SalesforceClient\REST\Gateway;

interface StrategyInterface
{
    public function buildAccessToken(Gateway $gateway): string;
}
