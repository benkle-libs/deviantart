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


use Benkle\Deviantart\Api;
use Benkle\Deviantart\ApiRequest;

class CommentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \PHPUnit_Framework_MockObject_MockObject[]
     */
    private function createMocks(): array
    {
        $requestMock = $this->createMock(ApiRequest::class);
        $requestMock
            ->expects($this->once())
            ->method('send')
            ->willReturn(new \stdClass());
        $apiMock = $this->createMock(Api::class);
        $apiMock
            ->expects($this->once())
            ->method('newRequest')
            ->willReturn($requestMock);
        return [$apiMock, $requestMock];
    }

    /**
     * @param $requestMock
     * @param $parameters
     */
    private function expectParameters($requestMock, $parameters)
    {
        $requestMock
            ->expects($this->any())
            ->method('setParameter')
            ->withConsecutive(...$parameters)
            ->willReturn($requestMock);
    }

    /**
     * @param $requestMock
     * @param $url
     */
    private function expectUrl($requestMock, $url)
    {
        $requestMock
            ->expects($this->once())
            ->method('setUrl')
            ->with($url)
            ->willReturn($requestMock);
    }

    public function testForDeviation()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/deviation/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['maxdepth', 5],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->forDeviation('aaa', 'bbb', 5,10, 20, true));
    }

    public function testForProfile()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/profile/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['maxdepth', 5],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->forProfile('aaa', 'bbb', 5,10, 20, true));
    }

    public function testForStatus()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/status/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['maxdepth', 5],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->forStatus('aaa', 'bbb', 5,10, 20, true));
    }

    public function testGetSiblings()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/aaa/siblings';

        $parameters = [
            ['ext_item', true],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->getSiblings('aaa', true,10, 20, true));
    }

    public function testPostToDeviation()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/post/deviation/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['body', 'ccc'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $requestMock
            ->expects($this->once())
            ->method('setMethod')
            ->with(ApiRequest::POST)
            ->willReturn($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->postToDeviation('aaa', 'ccc', 'bbb',true));
    }

    public function testPostToProfile()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/post/profile/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['body', 'ccc'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $requestMock
            ->expects($this->once())
            ->method('setMethod')
            ->with(ApiRequest::POST)
            ->willReturn($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->postToProfile('aaa', 'ccc', 'bbb',true));
    }

    public function testPostToStatus()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/comments/post/status/aaa';

        $parameters = [
            ['commentid', 'bbb'],
            ['body', 'ccc'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $requestMock
            ->expects($this->once())
            ->method('setMethod')
            ->with(ApiRequest::POST)
            ->willReturn($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $comments = new Comments($apiMock);
        $this->assertEquals(new \stdClass(), $comments->postToStatus('aaa', 'ccc', 'bbb',true));
    }
}
