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

class DeviationTest extends \PHPUnit_Framework_TestCase
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

    public function testGetDeviation()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/AAA';

        $this->expectUrl($requestMock, $url);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getDeviation('AAA'));
    }

    public function testGetContent()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/content';

        $parameters = [
            ['deviationid', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getContent('AAA', true));
    }

    public function testGetDownloadInfo()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/download/AAA';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getDownloadInfo('AAA', true));
    }

    public function testEmbeddedContent()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/embeddedcontent';

        $parameters = [
            ['deviationid', 'AAA'],
            ['offset_deviationid', 'BBB'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(
            new \stdClass(),
            $deviation->getEmbeddedContent('AAA', 'BBB', 10, 20, true)
        );
    }

    public function testGetWhoFaved()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/whofaved';

        $parameters = [
            ['deviationid', 'AAA'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(
            new \stdClass(),
            $deviation->getWhoFaved('AAA', 10, 20, true)
        );
    }

    public function testGetMetadata()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/deviation/metadata';

        $parameters = [
            ['deviationids', ['AAA']],
            ['ext_submission', false],
            ['ext_camera', true],
            ['ext_stats', false],
            ['ext_collection', true],
            ['mature_content', false],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Deviation($apiMock);
        $this->assertEquals(
            new \stdClass(),
            $deviation->getMetadata(['AAA'], false, true, false, true, false)
        );
    }
}
