<?php
declare(strict_types=1);

namespace Igdb\Resources;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Igdb\ApiException;
use Igdb\Config;
use Igdb\Response;

abstract class Resource
{
    private Config $config;
    private HttpClient $http;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->http = new HttpClient();
    }

    /**
     * @param string $path
     * @param string $query
     * @return \Igdb\Response
     * @throws \Igdb\ApiException
     */
    protected function get(string $path, string $query = ''): Response
    {
        $fullUrl = $this->config->getBaseUrl() . $path;

        try {
            $response = $this->http->request('POST', $fullUrl, [
                'headers' => [
                    'Authorization' => $this->config->getAuthorization(),
                    'Client-ID' => $this->config->getClientId()
                ],
                'body' => $query
            ]);
        } catch (GuzzleException $e) {
            throw new ApiException('Invalid API request: ' . $e->getMessage());
        }

        return new Response($response);
    }

    abstract function fetch(string $query = ''): Response;
}
