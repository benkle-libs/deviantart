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


namespace Benkle\Deviantart;


use Benkle\Deviantart\Endpoints\Browse;
use Benkle\Deviantart\Endpoints\Collections;
use Benkle\Deviantart\Endpoints\Comments;
use Benkle\Deviantart\Endpoints\Data;
use Benkle\Deviantart\Endpoints\Deviation;
use Benkle\Deviantart\Endpoints\Feed;
use Benkle\Deviantart\Endpoints\Gallery;
use Benkle\Deviantart\Endpoints\Messages;
use Benkle\Deviantart\Endpoints\Notes;
use Benkle\Deviantart\Endpoints\Stash;
use Benkle\Deviantart\Endpoints\User;
use Benkle\Deviantart\Endpoints\Utils;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    public function testBasics()
    {
        $providerMock = $this->createMock(AbstractProvider::class);
        $api = new Api($providerMock);

        $this->assertInstanceOf(Stash::class, $api->stash());
        $this->assertInstanceOf(Notes::class, $api->notes());
        $this->assertInstanceOf(Messages::class, $api->messages());
        $this->assertInstanceOf(Collections::class, $api->collections());
        $this->assertInstanceOf(User::class, $api->user());
        $this->assertInstanceOf(Comments::class, $api->comments());
        $this->assertInstanceOf(Feed::class, $api->feed());
        $this->assertInstanceOf(Utils::class, $api->utils());
        $this->assertInstanceOf(Browse::class, $api->browse());
        $this->assertInstanceOf(Deviation::class, $api->deviation());
        $this->assertInstanceOf(Gallery::class, $api->gallery());
        $this->assertInstanceOf(Data::class, $api->data());
        $this->assertEquals($providerMock, $api->getProvider());
    }
}
