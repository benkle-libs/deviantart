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

class GalleryTest extends \PHPUnit_Framework_TestCase
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

    public function testDeleteFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/gallery/folders/remove/AAA';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Gallery($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->deleteFolder('AAA', true));
    }

    public function testCreateFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/gallery/folders/create';

        $parameters = [
            ['deviationid', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Gallery($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->createFolder('AAA', true));
    }

    public function testGetAll()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/gallery/all';

        $parameters = [
            ['username', 'AAA'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Gallery($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getAll('AAA', 10, 20, true));
    }

    public function testGetFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/gallery/AAA';

        $parameters = [
            ['username', 'BBB'],
            ['mode', 'CCC'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Gallery($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getFolder('AAA', 'BBB', 'CCC', 10, 20, true));
    }

    public function testGetFolders()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/gallery/folders';

        $parameters = [
            ['username', 'AAA'],
            ['calculate_size', true],
            ['ext_preload', false],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $deviation = new Gallery($apiMock);
        $this->assertEquals(new \stdClass(), $deviation->getFolders('AAA', true, false, 10, 20, true));
    }
}
