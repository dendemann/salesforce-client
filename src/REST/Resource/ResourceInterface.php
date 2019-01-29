<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\Resource;

/**
 * Marker interface
 */
interface ResourceInterface
{

    /**
     * var string
     */
    const RESOURCE_SOBJECTS = 'sobjects';

    /**
     * var string
     */
    const RESOURCE_QUERY = 'query';

    /**
     * var string
     */
    const RESOURCE_QUERY_ALL = 'queryAll';

    /**
     * var string
     */
    const RESOURCE_JOBS = 'jobs';

}