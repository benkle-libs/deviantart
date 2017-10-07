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

class CollectionsTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testGetFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/AAA';

        $parameters = [
            ['username', 'BBB'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->getFolder('AAA', 'BBB', 10, 20, true));
    }

    public function testFave()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/fave';

        $parameters = [
            ['deviationid', 'AAA'],
            ['folderid', ['BBB']],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->fave('AAA', ['BBB'], true));
    }

    public function testUnfave()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/unfave';

        $parameters = [
            ['deviationid', 'AAA'],
            ['folderid', ['BBB']],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->unfave('AAA', ['BBB'], true));
    }

    public function testGetFolders()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/folders';

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

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->getFolders('AAA', true, false, 10, 20, true));
    }

    public function testCreateFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/folders/create';

        $parameters = [
            ['folder', 'AAA'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->createFolder('AAA', true));
    }

    public function testDeleteFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/collections/folders/remove/AAA';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $collections = new Collections($apiMock);
        $this->assertEquals(new \stdClass(), $collections->deleteFolder('AAA', true));
    }
}
