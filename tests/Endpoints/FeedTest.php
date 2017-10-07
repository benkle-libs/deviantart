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


namespace Benkle\Deviantart\Endpoints;

require_once __DIR__ . '/EndpointHelperTrait.php';

use Benkle\Deviantart\Api;
use Benkle\Deviantart\ApiRequest;

class FeedTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testGetNotifications()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/notifications';

        $parameters = [
            ['cursor', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->getNotifications('AAA', true));
    }

    public function testGetHome()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/home';

        $parameters = [
            ['cursor', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->getHome('AAA', true));
    }

    public function testGetBucket()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/home/AAA';

        $parameters = [
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->getBucket('AAA', 10, 20, true));
    }

    public function testGetProfile()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/profile';

        $parameters = [
            ['cursor', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->getProfile('AAA', true));
    }

    public function testGetSettings()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/settings';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->getSettings(true));
    }

    public function testUpdateSettings()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/feed/settings/update';

        $parameters = [
            ['include', ['foo' => 'bar']],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $feed = new Feed($apiMock);
        $this->assertEquals(new \stdClass(), $feed->updateSettings(['foo' => 'bar'], true));
    }
}
