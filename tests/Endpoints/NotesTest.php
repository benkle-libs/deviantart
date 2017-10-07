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

class NotesTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testGetNotes()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes';

        $parameters = [
            ['folderid', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getNotes('aaa', 10, 20, true));
    }

    public function testGetFolders()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/folders';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getFolders(true));
    }

    public function testGet()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->get('aaa',true));
    }

    public function testCreateFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/folders/create';

        $parameters = [
            ['title', 'aaa'],
            ['parentid', 'bbb'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->createFolder('aaa', 'bbb',true));
    }

    public function testRemoveFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/folders/remove/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->removeFolder('aaa',true));
    }

    public function testRenameFolder()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/folders/rename/aaa';

        $parameters = [
            ['title', 'bbb'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->renameFolder('aaa', 'bbb',true));
    }

    public function testSend()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/send';

        $parameters = [
            ['to', ['aaa']],
            ['subject', 'bbb'],
            ['body', 'ccc'],
            ['noteid', 'ddd'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->send(['aaa'], 'bbb', 'ccc', 'ddd',true));
    }

    public function testDelete()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/delete';

        $parameters = [
            ['noteids', ['aaa']],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->delete(['aaa'], true));
    }

    public function testMove()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/move';

        $parameters = [
            ['noteids', ['aaa']],
            ['folderid', 'bbb'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->move(['aaa'], 'bbb', true));
    }

    public function testMark()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/notes/mark';

        $parameters = [
            ['noteids', ['aaa']],
            ['mark_as', 'bbb'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Notes($apiMock);
        $this->assertEquals(new \stdClass(), $notes->mark(['aaa'], 'bbb', true));
    }
}
