<?php declare(strict_types=1);

namespace WakeOnWeb\SalesforceClient\REST\GrantType;

use GuzzleHttp\Client as HttpClient;
use WakeOnWeb\SalesforceClient\Exception;
use WakeOnWeb\SalesforceClient\REST\Gateway;

class PasswordStrategy implements StrategyInterface
{

    /**
     * @var string
     */
    private $consumerKey;

    /**
     * @var string
     */
    private $consumerSecret;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    const GRANT_TYPE = 'password';

    /**
     * @var string
     */
    const OAUTH_TOKEN_PATH = '/services/oauth2/token';

    public function __construct(
        string $consumerKey,
        string $consumerSecret,
        string $login,
        string $password,
        string $token
    ) {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
        $this->login = $login;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * @param Gateway $gateway
     * @return string
     * @throws Exception\AuthenticationException
     * @throws Exception\UnexpectedPayloadException
     */
    public function buildAccessToken(Gateway $gateway): string
    {
        $data = [
            'grant_type' => static::GRANT_TYPE,
            'client_id' => $this->consumerKey,
            'client_secret' => $this->consumerSecret,
            'username' => $this->login,
            'password' => $this->password . $this->token,
        ];

        try {
            $client = new HttpClient();
            $response = $client->post($gateway->getEndpoint() . static::OAUTH_TOKEN_PATH, [
                'form_params' => $data,
            ])->getBody();
        } catch (\Exception $e) {
            throw new Exception\AuthenticationException($e->getMessage(), 0, $e);
        }

        $responseDecoded = json_decode($response, true);

        if (false === array_key_exists('access_token', $responseDecoded)) {
            throw new Exception\UnexpectedPayloadException(sprintf('access_token field cannot be found in services/oauth2/token response: %s',
                (string)$response));
        }

        return $responseDecoded['access_token'];
    }
}
