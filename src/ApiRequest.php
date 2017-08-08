<?php
/*
 * Copyright (c) 2017 Benjamin Kleiner
 *
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.  IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


namespace Benkle\Deviantart;


use Benkle\Deviantart\Exceptions\ApiException;
use GuzzleHttp\Exception\ClientException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class ApiRequest
 * @package Benkle\Deviantart
 */
class ApiRequest
{
    const POST = 'POST';
    const GET = 'GET';

    /** @var  string */
    private $method = self::GET;

    /** @var  mixed[] */
    private $parameters = [];

    /** @var  AbstractProvider */
    private $provider;

    /** @var  string */
    private $url;

    /** @var  AccessToken */
    private $accessToken;

    /**
     * ApiRequest constructor.
     * @param AbstractProvider $provider
     * @param AccessToken $accessToken
     */
    public function __construct(AbstractProvider $provider, AccessToken $accessToken)
    {
        $this->provider = $provider;
        $this->accessToken = $accessToken;
    }

    /**
     * Get the OAuth2 provider.
     * @return AbstractProvider
     */
    public function getProvider(): AbstractProvider
    {
        return $this->provider;
    }

    /**
     * Get the access token.
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * Get the HTTP method.
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Set the HTTP method.
     * @param string $method
     * @return ApiRequest
     */
    public function setMethod(string $method): ApiRequest
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get the set of all parameters.
     * @return mixed[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Get a single parameter.
     * @param string $key
     * @return mixed
     */
    public function getParameter(string $key)
    {
        return $this->parameters[$key];
    }

    /**
     * Set the set of all parameters.
     * @param mixed[] $parameters
     * @return ApiRequest
     */
    public function setParameters(array $parameters): ApiRequest
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * Set a single parameter.
     * @param string $key
     * @param mixed $value
     * @return ApiRequest
     */
    public function setParameter(string $key, $value): ApiRequest
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * Get the request url (minus GET parameters).
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Set the request url (minus GET parameters).
     * @param string $url
     * @return ApiRequest
     */
    public function setUrl(string $url): ApiRequest
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Send the request.
     * @return \stdClass
     * @throws ApiException
     */
    public function send(): \stdClass
    {
        $url = $this->getUrl();
        $options = [];
        $parameters = array_filter($this->getParameters());
        if ($parameters) {
            if ($this->getMethod() == self::GET) {
                $url .= '?' . http_build_query($parameters);
            } else {
                $options['body'] = http_build_query($parameters, '', '&');
                $options['headers'] = [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ];
            }
        }
        $request = $this->getProvider()->getAuthenticatedRequest(
            $this->getMethod(),
            $url,
            $this->getAccessToken()->getToken(),
            $options
        );
        try {
            $response = $this->getProvider()->getHttpClient()->send($request);
        } catch (ClientException $e) {
            if (!$e->hasResponse()) {
                throw $e;
            }
            $response = $e->getResponse();
            throw new ApiException(
                $response->getStatusCode(),
                $response->getBody()->getContents()
            );
        }
        return json_decode($response->getBody()->getContents());
    }
}
