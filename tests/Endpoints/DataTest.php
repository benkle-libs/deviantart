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

class DataTest extends \PHPUnit_Framework_TestCase
{
    use EndpointHelperTrait;

    public function testCountries()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/data/countries';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $data = new Data($apiMock);
        $this->assertEquals(new \stdClass(), $data->getCountries(true));
    }

    public function testTermsOfService()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/data/tos';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $data = new Data($apiMock);
        $this->assertEquals(new \stdClass(), $data->getTermsOfService(true));
    }

    public function testPrivacyPolicy()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/data/privacy';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $data = new Data($apiMock);
        $this->assertEquals(new \stdClass(), $data->getPrivacyPolicy(true));
    }

    public function testSubmissionPolicy()
    {
        list($apiMock, $requestMock) = $this->createMocks();

        $url = Api::URL . '/data/submission';

        $parameters = [
            ['mature_content', true],
        ];

        $this->expectUrl($requestMock, $url);
        $this->expectParameters($requestMock, $parameters);

        $data = new Data($apiMock);
        $this->assertEquals(new \stdClass(), $data->getSubmissionPolicy(true));
    }
}
