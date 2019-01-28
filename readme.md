PHP Salesforce client
=====================

Salesforce client forked from https://github.com/WakeOnWeb/salesforce-client

Supported technologies:

    - rest
        - oauth2 grant type: password.

Please, contribute to support other one.

Usage
-----

```php
use WakeOnWeb\SalesforceClient\REST;
use WakeOnWeb\SalesforceClient\ClientInterface;

$client = new REST\Client(
    new REST\Gateway('https://cs81.salesforce.com', '41.0'),
    new REST\GrantType\PasswordStrategy(
        'consumer_key',
        'consumer_secret',
        'login',
        'password',
        'security_token'
    )
);
```
Available exception -------------------

- DuplicatesDetectedException
- EntityIsDeletedException (when try to delete an entity already deleted)
- NotFoundException (when an object cannot be found)
- ...

Get sobjects resource
-----------
```php
$sobjectsResource = $client->getResource(REST\Resource\ResourceInterface::RESOURCE_SOBJECTS);
```

Get object
-----------

```php
try {
    $salesforceObject = $sobjectsResource->getObject( 'Account', '1337ID')); // all fields
} catch (\WakeOnWeb\SalesforceClient\Exception\NotFoundException) {
    // this object does not exist, do a specifig thing.
}

//$salesforceObject->getAttributes();
//$salesforceObject->getFields();

//$sobjectsResource->getObject( 'Account', '1337ID', ['Name', 'OwnerId', 'CreatedAt'] )); // specific fields
```

Create object 
-----------

```php
// creation will be a SalesforceObjectCreationObject
$creation = $sobjectsResource->createObject( 'Account', ['name' => 'Chuck Norrs'] );
// $creation->getId();
// $creation->isSuccess();
// $creation->getErrors();
// $creation->getWarnings();
```

Edit object 
-----------

```php
$sobjectsResource->patchObject( 'Account', '1337ID', ['name' => 'Chuck Norris'] ));
```

Delete object 
-----------

```
$sobjectsResource->deleteObject( 'Account', '1337ID'));
```

Other object info
-----------

```php
$sobjectsResource->getAllObjects();
$sobjectsResource->describeObjectMetadata('Account');
```

SOQL
----

```php
// creation will be a SalesforceObjectCreationObjectResults
$queryResource = $client->getResource(REST\Resource\ResourceInterface::RESOURCE_QUERY);
$queryResource->searchSOQL('SELECT name from Account');
$queryAllResource = $client->getResource(REST\Resource\ResourceInterface::RESOURCE_QUERY_ALL);
$queryAllResource->searchSOQL('SELECT name from Account');
// $creation->getTotalSize();
// $creation->isDone();
// $creation->getRecords();
```

Other
-----

```php
$client->getAvailableResources();
```
