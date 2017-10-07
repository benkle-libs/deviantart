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

class UserTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testWhoAmI()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/whoami';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(new \stdClass(), $gallery->whoAmI(true));
    }

    public function testWhoIs()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/whois';

        $parameters = [
            ['usernames', ['aaa', 'bbb']],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(new \stdClass(), $gallery->whoIs(['aaa', 'bbb'], true));
    }

    public function testGetFriends()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/friends/aaa';

        $parameters = [
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(new \stdClass(), $gallery->getFriends('aaa', 10, 20, true));
    }

    public function testWatch()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/friends/watch/aaa';

        $parameters = [
            [
                'watch',
                [
                    'friend'        => true,
                    'deviations'    => false,
                    'journals'      => true,
                    'forum_threads' => false,
                    'critiques'     => true,
                    'scraps'        => false,
                    'activity'      => true,
                    'collections'   => false,
                ],
            ],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->watch(
            'aaa',
            true,
            false,
            true,
            false,
            true,
            false,
            true,
            false,
            true
        )
        );
    }

    public function testUnwatch()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/friends/unwatch/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->unwatch('aaa', true)
        );
    }

    public function testAmIWatching()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/friends/watching/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->amIWatching('aaa', true)
        );
    }

    public function testFindFriends()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/friends/search';

        $parameters = [
            ['username', 'bbb'],
            ['query', 'aaa'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->findFriends('aaa', 'bbb', true)
        );
    }

    public function testGetStatus()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/statuses/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->getStatus('aaa', true)
        );
    }

    public function testPostStatus()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/statuses/post';

        $parameters = [
            ['body', 'aaa'],
            ['id', 'ccc'],
            ['parentid', 'bbb'],
            ['stashid', 'ddd'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->postStatus(
                'aaa',
                'bbb',
                'ccc',
                'ddd',
                true
            )
        );
    }

    public function testGetStatuses()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/statuses/';

        $parameters = [
            ['username', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->getStatuses(
            'aaa',
            10,
            20,
            true
        )
        );
    }

    public function testGetDamnToken()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/damntoken';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->getDamnToken(true)
        );
    }

    public function testGetProfile()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/profile/aaa';

        $parameters = [
            ['ext_collections', true],
            ['ext_galleries', false],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->getProfile(
                'aaa',
                true,
                false,
                true
            )
        );
    }

    public function testGetWatchers()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/user/watchers/aaa';

        $parameters = [
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $gallery = new User($apiMock);
        $this->assertEquals(
            new \stdClass(), $gallery->getWatchers(
            'aaa',
            10,
            20,
            true
        )
        );
    }
}
