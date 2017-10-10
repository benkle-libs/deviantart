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


use Psr\Http\Message\StreamInterface;

class ApiRequestPartTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $streamMock = $this->createMock(StreamInterface::class);

        $part = new ApiRequestPart('aaa', $streamMock, 'bbb');

        $this->assertEquals('aaa', $part->getName());
        $this->assertEquals('bbb', $part->getFilename());
        $this->assertEquals($streamMock, $part->getStream());
    }

    public function testGettersSetters()
    {
        $streamMock = $this->createMock(StreamInterface::class);
        $streamMock2 = $this->createMock(StreamInterface::class);

        $part = new ApiRequestPart('aaa', $streamMock, 'bbb');

        $this->assertEquals($part, $part->setName('bbb'));
        $this->assertEquals('bbb', $part->getName());

        $this->assertEquals($part, $part->setFilename('aaa'));
        $this->assertEquals('aaa', $part->getFilename());

        $this->assertEquals($part, $part->setStream($streamMock2));
        $this->assertEquals($streamMock2, $part->getStream());
    }

    public function testSerialize()
    {
        $streamMock = $this->createMock(StreamInterface::class);

        $part = new ApiRequestPart('aaa', $streamMock, 'bbb');

        $this->assertEquals(
            [
                'name'     => 'aaa',
                'contents' => $streamMock,
                'filename' => 'bbb',
            ], $part->serialize()
        );
    }
}
