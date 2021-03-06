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

class MessagesTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testGetFeedback()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/feedback';

        $parameters = [
            ['type', 'aaa'],
            ['folderid', 'bbb'],
            ['stack', true],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->getFeedback('aaa','bbb',true,10,20,true));
    }

    public function testGetFeedbackFromStack()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/feedback/aaa';

        $parameters = [
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->getFeedbackFromStack('aaa',10,20,true));
    }

    public function testGetMentions()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/mentions';

        $parameters = [
            ['folderid', 'aaa'],
            ['stack', true],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->getMentions('aaa',true,10,20,true));
    }

    public function testGetMentionsFromStack()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/mentions/aaa';

        $parameters = [
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->getMentionsFromStack('aaa',10,20,true));
    }

    public function testGetAll()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/feed';

        $parameters = [
            ['folderid', 'aaa'],
            ['cursor', 'bbb'],
            ['stack', false],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->getAll('aaa','bbb',false,true));
    }

    public function testDelete()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/messages/delete';

        $parameters = [
            ['folderid', 'aaa'],
            ['messageid', 'bbb'],
            ['stackid', 'ccc'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectPost($requestMock);
        $this->expectParameters($requestMock, $parameters);

        $messages = new Messages($apiMock);
        $this->assertEquals(new \stdClass(), $messages->delete('aaa','bbb','ccc',true));
    }
}
