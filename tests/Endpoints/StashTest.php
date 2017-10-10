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

require_once __DIR__ . '/EndpointHelperTrait.php';


class StashTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testSubmit()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/submit';

        $parameters = [
            ['title', 'aaa'],
            ['artists_comment', 'bbb'],
            ['tags', ['ccc']],
            ['original_url', 'ddd'],
            ['is_dirty', false],
            ['item_id', 1],
            ['stack_id', 2],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $request = $notes->submit('aaa', 'bbb', ['ccc'], 'ddd', false, 1, 2, true);
        $this->assertInstanceOf(ApiRequest::class, $request);
        $this->assertEquals(new \stdClass(), $request->send());
    }

    public function testGetSpace()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/space';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getSpace(true));
    }

    public function testGetDelta()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/delta';

        $parameters = [
            ['cursor', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['ext_submission', true],
            ['ext_camera', false],
            ['ext_stats', true],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getDelta('aaa', 10, 20, true, false, true, true));
    }

    public function testDelete()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/delete';

        $parameters = [
            ['itemid', 'aaa'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->delete('aaa', true));
    }

    public function testMoveStack()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/move/aaa';

        $parameters = [
            ['targetid', 'bbb'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->moveStack('aaa', 'bbb', true));
    }

    public function testPublish()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/publish';

        $parameters = [
            ['itemid', 'aaa'],
            ['is_mature', true],
            ['agree_submission', false],
            ['agree_tos', true],
            ['catpath', 'bbb'],
            ['galleryids', ['ccc']],
            ['license_options', 1],
            ['mature_level', 'ddd'],
            ['mature_classification', ['eee']],
            ['allow_comments', false],
            ['allow_free_download', true],
            ['add_watermark', false],
            ['request_critique', true],
            ['feature', false],
            ['sharing', true],
            ['display_resolution', 2],
            ['mature_content', false],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->publish(
            'aaa',
            true,
            false,
            true,
            'bbb',
            ['ccc'],
            1,
            'ddd',
            ['eee'],
            false,
            true,
            false,
            true,
            false,
            true,
            2,
            false));
    }

    public function testGetCategoryTree()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/publish/categorytree';

        $parameters = [
            ['catpath', 'aaa'],
            ['filetype', 'bbb'],
            ['frequent', false],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getCategoryTree('aaa', 'bbb', false, true));
    }

    public function testGetUserData()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/publish/userdata';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getUserData(true));
    }

    public function testChangeStackPosition()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/position/aaa';

        $parameters = [
            ['position', 10],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->changeStackPosition('aaa', 10, true));
    }

    public function testUpdate()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/update/aaa';

        $parameters = [
            ['title', 'bbb'],
            ['description', 'ccc'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->update('aaa', 'bbb', 'ccc', true));
    }

    public function testGetItem()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/item/aaa';

        $parameters = [
            ['ext_submission', true],
            ['ext_camera', false],
            ['ext_stats', true],
            ['mature_content', false],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getItem('aaa', true, false, true, false));
    }

    public function testGetStack()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/stash/aaa';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $notes = new Stash($apiMock);
        $this->assertEquals(new \stdClass(), $notes->getStack('aaa', true));
    }

    public function tetStackContent()
    {
    }

}
