<?php
namespace PHPSTORM_META {

    override(\WakeOnWeb\SalesforceClient\ClientInterface::getResource(0),
        map([
            'sobjects' => '\WakeOnWeb\SalesforceClient\REST\Resource\SObjectsResource',
            'query' => '\WakeOnWeb\SalesforceClient\REST\Resource\QueryResource',
            'queryAll' => '\WakeOnWeb\SalesforceClient\REST\Resource\QueryAllResource',
            'jobs' => '\WakeOnWeb\SalesforceClient\REST\Resource\JobsResource'
        ])
    );

}