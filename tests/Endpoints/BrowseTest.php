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

class BrowseTest extends \PHPUnit_Framework_TestCase
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

    public function testMoreLikeThis()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/morelikethis';

        $parameters = [
            ['seed', 'aaa'],
            ['category', 'bbb'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getMoreLikeThis('aaa', 'bbb', 10, 20, true));
    }

    public function testMoreLikeThisPreview()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/morelikethis/preview';

        $parameters = [
            ['seed', 'aaa'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getMoreLikeThisPreview('aaa', true));
    }

    public function testDailyDeviations()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/dailydeviations';

        $date = new \DateTime();

        $parameters = [
            ['date', $date->format('Y-m-d')],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getDailyDeviations($date, true));
    }

    public function testTag()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/tags';

        $parameters = [
            ['tag', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getTag('aaa', 10, 20, true));
    }

    public function testSearchTags()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/tags/search';

        $parameters = [
            ['tag_name', 'aaa'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->searchTags('aaa', true));
    }

    public function testUserJournals()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/user/journals';

        $parameters = [
            ['username', 'aaa'],
            ['featured', true],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getUserJournals('aaa', true, 10, 20, true));
    }

    public function testNewest()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/newest';

        $parameters = [
            ['category_path', 'aaa'],
            ['q', 'bbb'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getNewest('aaa', 'bbb', 10, 20, true));
    }

    public function testPopular()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/popular';

        $parameters = [
            ['category_path', 'aaa'],
            ['q', 'bbb'],
            ['timerange', Api::TIMERANGE_1_WEEK],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getPopular('aaa', 'bbb', Api::TIMERANGE_1_WEEK, 10, 20, true));
    }

    public function testHot()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/hot';

        $parameters = [
            ['category_path', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getHot('aaa', 10, 20, true));
    }

    public function testUndiscovered()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/undiscovered';

        $parameters = [
            ['category_path', 'aaa'],
            ['offset', 10],
            ['limit', 20],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getUndiscovered('aaa', 10, 20, true));
    }

    public function testCategoryTree()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/browse/categorytree';

        $parameters = [
            ['catpath', 'aaa'],
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $browse = new Browse($apiMock);
        $this->assertEquals(new \stdClass(), $browse->getCategoryTree('aaa', true));
    }
}
