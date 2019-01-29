<?php
namespace PHPSTORM_META {

    override(\WakeOnWeb\SalesforceClient\ClientInterface::getResource(0),
        map([
            'sobjects' => '\WakeOnWeb\SalesforceClient\REST\Resource\SObjects',
            'query' => '\WakeOnWeb\SalesforceClient\REST\Resource\Query',
            'queryAll' => '\WakeOnWeb\SalesforceClient\REST\Resource\QueryAll',
            'jobs' => '\WakeOnWeb\SalesforceClient\REST\Resource\Jobs'
        ])
    );

}