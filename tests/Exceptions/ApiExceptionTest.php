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


namespace Benkle\Deviantart\Exceptions;


class ApiExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicException()
    {
        $exception = new ApiException(
            400, json_encode(
            [
                'error'             => 'foo',
                'error_description' => 'bar',
            ]
        )
        );

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('foo: bar', $exception->getMessage());
        $this->assertEquals('foo', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(true, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals([], $exception->getDetails());
    }

    public function testExceptionWithCode()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'foo',
                'error_description' => 'bar',
                'error_code'        => 1
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('foo: bar (1)', $exception->getMessage());
        $this->assertEquals('foo', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(1, $exception->getErrorCode());
        $this->assertEquals(true, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals([], $exception->getDetails());
    }

    public function testExceptionWithDetails()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'foo',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('foo: bar', $exception->getMessage());
        $this->assertEquals('foo', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(true, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testInvalidRequest()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'invalid_request',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('invalid_request: bar', $exception->getMessage());
        $this->assertEquals('invalid_request', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(false, $exception->is('foo'));
        $this->assertEquals(true, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testUnauthorized()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'unauthorized',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('unauthorized: bar', $exception->getMessage());
        $this->assertEquals('unauthorized', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(false, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(true, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testUnverifiedAccount()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'unverified_account',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('unverified_account: bar', $exception->getMessage());
        $this->assertEquals('unverified_account', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(false, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(true, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testServerError()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'server_error',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('server_error: bar', $exception->getMessage());
        $this->assertEquals('server_error', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(false, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(true, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testVersionError()
    {
        $exception = new ApiException(400, json_encode(
            [
                'error'             => 'version_error',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(400, $exception->getCode());
        $this->assertEquals('version_error: bar', $exception->getMessage());
        $this->assertEquals('version_error', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(false, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(false, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(true, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }

    public function testRateLimited()
    {
        $exception = new ApiException(429, json_encode(
            [
                'error'             => 'foo',
                'error_description' => 'bar',
                'error_details'     => [
                    'foo' => 'bar'
                ]
            ]
        ));

        $this->assertEquals(429, $exception->getCode());
        $this->assertEquals('foo: bar', $exception->getMessage());
        $this->assertEquals('foo', $exception->getType());
        $this->assertEquals('bar', $exception->getDescription());
        $this->assertEquals(0, $exception->getErrorCode());
        $this->assertEquals(true, $exception->is('foo'));
        $this->assertEquals(false, $exception->isInvalidRequest());
        $this->assertEquals(true, $exception->isRateLimited());
        $this->assertEquals(false, $exception->isServerError());
        $this->assertEquals(false, $exception->isUnauthorized());
        $this->assertEquals(false, $exception->isUnverifiedAccount());
        $this->assertEquals(false, $exception->isVersionError());
        $this->assertEquals(['foo' => 'bar'], $exception->getDetails());
    }
}
