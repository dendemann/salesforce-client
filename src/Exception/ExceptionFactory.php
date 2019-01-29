<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\Exception;

use GuzzleHttp\Exception\RequestException;

abstract class ExceptionFactory
{

    /**
     * @param RequestException $e
     * @return SalesforceClientException
     */
    public static function generateFromRequestException(RequestException $e): SalesforceClientException
    {
        $body = (string) $e->getResponse()->getBody();
        $data = json_decode($body, true);

        if (false === is_array($data)) {
            return static::createDefaultException($e);
        }

        $error = current($data);

        if (false === is_array($error) || false === array_key_exists('errorCode', $error)) {
            return static::createDefaultException($e);
        }

        $message = static::generateErrorMessage($error, $e);

        switch ($error['errorCode']) {
            case 'DUPLICATES_DETECTED':
                return new DuplicatesDetectedException($message);
                break;
            case 'ENTITY_IS_DELETED':
                return new EntityIsDeletedException($message);
                break;
            case 'NOT_FOUND':
                return new NotFoundException($message);
                break;
            default:
                return ErrorCodeException::createFromCode($error['errorCode'], $message);
            break;
        }
    }

    /**
     * @param array $error
     * @param RequestException $e
     * @return string
     */
    private static function generateErrorMessage(array $error, RequestException $e): string
    {
        $message = array_key_exists('message', $error) ? $error['message'] : $e->getMessage();
        $message .= "\nRequest: ".$e->getRequest()->getUri();

        return $message;
    }

    /**
     * @param RequestException $e
     * @return SalesforceClientException
     */
    private static function createDefaultException(RequestException $e): SalesforceClientException
    {
        return new SalesforceClientException($e->getMessage(), 0, $e);
    }

}
