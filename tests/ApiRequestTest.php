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


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\StreamInterface;

class ApiRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $providerMock = $this->createMock(AbstractProvider::class);
        $accessTokenMock = $this->createMock(AccessToken::class);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $this->assertEquals($providerMock, $request->getProvider());
        $this->assertEquals($accessTokenMock, $request->getAccessToken());
    }

    public function testMethod()
    {
        $providerMock = $this->createMock(AbstractProvider::class);
        $accessTokenMock = $this->createMock(AccessToken::class);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $this->assertEquals($request, $request->setMethod('test'));
        $this->assertEquals('test', $request->getMethod());
    }


    public function testParameters()
    {
        $providerMock = $this->createMock(AbstractProvider::class);
        $accessTokenMock = $this->createMock(AccessToken::class);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $this->assertEquals($request, $request->setParameters(['foo' => 'bar']));
        $this->assertEquals(['foo' => 'bar'], $request->getParameters());
        $this->assertEquals('bar', $request->getParameter('foo'));
        $this->assertEquals($request, $request->setParameter('foo', 'baz'));
        $this->assertEquals(['foo' => 'baz'], $request->getParameters());
        $this->assertEquals('baz', $request->getParameter('foo'));
        $this->assertEquals($request, $request->setParameters(['bar' => ['foo', 'foo']]));
        $this->assertEquals(['bar' => ['foo', 'foo']], $request->getParameters());
    }

    public function testUrl()
    {
        $providerMock = $this->createMock(AbstractProvider::class);
        $accessTokenMock = $this->createMock(AccessToken::class);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $this->assertEquals($request, $request->setUrl('test'));
        $this->assertEquals('test', $request->getUrl());
    }

    public function testGet()
    {
        $bodyMock = $this->createMock(StreamInterface::class);
        $bodyMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('{"foo": "bar"}');
        $responseMock = $this->createMock(Response::class);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($bodyMock);
        $requestMock = $this->createMock(Request::class);
        $clientMock = $this->createMock(Client::class);
        $accessTokenMock = $this->createMock(AccessToken::class);
        $accessTokenMock
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('TOKEN');
        $providerMock = $this->createMock(AbstractProvider::class);
        $providerMock
            ->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($clientMock);
        $clientMock
            ->expects($this->once())
            ->method('send')
            ->with($requestMock)
            ->willReturn($responseMock);
        $providerMock
            ->expects($this->once())
            ->method('getAuthenticatedRequest')
            ->with(
                       ApiRequest::GET,
                       'http://example.com?foo=bar',
                       'TOKEN',
                       []
                   )
            ->willReturn($requestMock);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $result = $request
            ->setMethod(ApiRequest::GET)
            ->setUrl('http://example.com')
            ->setParameter('foo', 'bar')
            ->send()
        ;
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals('bar', $result->foo);
    }

    public function testPost()
    {
        $bodyMock = $this->createMock(StreamInterface::class);
        $bodyMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('{"foo": "bar"}');
        $responseMock = $this->createMock(Response::class);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($bodyMock);
        $requestMock = $this->createMock(Request::class);
        $clientMock = $this->createMock(Client::class);
        $accessTokenMock = $this->createMock(AccessToken::class);
        $accessTokenMock
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('TOKEN');
        $providerMock = $this->createMock(AbstractProvider::class);
        $providerMock
            ->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($clientMock);
        $clientMock
            ->expects($this->once())
            ->method('send')
            ->with($requestMock)
            ->willReturn($responseMock);
        $providerMock
            ->expects($this->once())
            ->method('getAuthenticatedRequest')
            ->with(
                ApiRequest::POST,
                'http://example.com',
                'TOKEN',
                [
                    'body' => 'foo=bar',
                    'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']
                ]
            )
            ->willReturn($requestMock);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $result = $request
            ->setMethod(ApiRequest::POST)
            ->setUrl('http://example.com')
            ->setParameter('foo', 'bar')
            ->send()
        ;
        $this->assertInstanceOf(\stdClass::class, $result);
        $this->assertEquals('bar', $result->foo);
    }

    /**
     * @expectedException \Benkle\Deviantart\Exceptions\ApiException
     * @expectedExceptionCode 444
     * @expectedExceptionMessage foo: bar
     */
    public function testGetExceptionWithBody()
    {
        $bodyMock = $this->createMock(StreamInterface::class);
        $bodyMock
            ->expects($this->once())
            ->method('getContents')
            ->willReturn('{"error": "foo", "error_description": "bar"}');
        $responseMock = $this->createMock(Response::class);
        $responseMock
            ->expects($this->once())
            ->method('getBody')
            ->willReturn($bodyMock);
        $responseMock
            ->expects($this->once())
            ->method('getStatusCode')
            ->willReturn(444);
        $requestMock = $this->createMock(Request::class);
        $clientMock = $this->createMock(Client::class);
        $accessTokenMock = $this->createMock(AccessToken::class);
        $accessTokenMock
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('TOKEN');
        $providerMock = $this->createMock(AbstractProvider::class);
        $providerMock
            ->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($clientMock);
        $exceptionMock = $this->createMock(ClientException::class);
        $exceptionMock
            ->expects($this->once())
            ->method('hasResponse')
            ->willReturn(true);
        $exceptionMock
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn($responseMock);
        $clientMock
            ->expects($this->once())
            ->method('send')
            ->with($requestMock)
            ->willThrowException($exceptionMock);
        $providerMock
            ->expects($this->once())
            ->method('getAuthenticatedRequest')
            ->with(
                ApiRequest::GET,
                'http://example.com?foo=bar',
                'TOKEN',
                []
            )
            ->willReturn($requestMock);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $request
            ->setMethod(ApiRequest::GET)
            ->setUrl('http://example.com')
            ->setParameter('foo', 'bar')
            ->send()
        ;
    }

    /**
     * @expectedException \GuzzleHttp\Exception\ClientException
     */
    public function testGetExceptionWithoutBody()
    {
        $requestMock = $this->createMock(Request::class);
        $clientMock = $this->createMock(Client::class);
        $accessTokenMock = $this->createMock(AccessToken::class);
        $accessTokenMock
            ->expects($this->once())
            ->method('getToken')
            ->willReturn('TOKEN');
        $providerMock = $this->createMock(AbstractProvider::class);
        $providerMock
            ->expects($this->once())
            ->method('getHttpClient')
            ->willReturn($clientMock);
        $exceptionMock = $this->createMock(ClientException::class);
        $exceptionMock
            ->expects($this->once())
            ->method('hasResponse')
            ->willReturn(false);
        $clientMock
            ->expects($this->once())
            ->method('send')
            ->with($requestMock)
            ->willThrowException($exceptionMock);
        $providerMock
            ->expects($this->once())
            ->method('getAuthenticatedRequest')
            ->with(
                ApiRequest::GET,
                'http://example.com?foo=bar',
                'TOKEN',
                []
            )
            ->willReturn($requestMock);

        $request = new ApiRequest($providerMock, $accessTokenMock);

        $request
            ->setMethod(ApiRequest::GET)
            ->setUrl('http://example.com')
            ->setParameter('foo', 'bar')
            ->send()
        ;
    }

}
