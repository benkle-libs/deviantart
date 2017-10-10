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

use function GuzzleHttp\Psr7\stream_for;
use Psr\Http\Message\StreamInterface;

/**
 * Class ApiRequestPart
 * @package Benkle\Deviantart
 */
class ApiRequestPart
{
    /** @var  string */
    private $name;

    /** @var  StreamInterface */
    private $stream;

    /** @var  string */
    private $filename;

    /**
     * ApiRequestPart constructor.
     *
     * @param string $name
     * @param StreamInterface $stream
     * @param string $filename
     */
    public function __construct($name, StreamInterface $stream, $filename = null)
    {
        $this->name = $name;
        $this->stream = $stream;
        $this->filename = $filename;
    }

    /**
     * Get the part name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the part name.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): ApiRequestPart
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get the data stream.
     *
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return $this->stream;
    }

    /**
     * Set the data stream.
     *
     * @param StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream): ApiRequestPart
    {
        $this->stream = $stream;
        return $this;
    }

    /**
     * Get the filename.
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Set the filename.
     *
     * @param string $filename
     * @return $this
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    /**
     * Serialize for usage with Guzzle PSR-7.
     *
     * @return array
     */
    public function serialize(): array
    {
        $result = [
            'name'     => $this->getName(),
            'contents' => $this->getStream(),
        ];

        if ($this->filename) {
            $result['filename'] = $this->filename;
        }

        return $result;
    }

    /**
     * Factory method for easier usage.
     *
     * @param string $name
     * @param mixed $content
     * @param string $filename
     * @return ApiRequestPart
     */
    public static function from(string $name, $content, string $filename = null): ApiRequestPart
    {
        $content = stream_for($content);
        return new self($name, $content, $filename);
    }
}
