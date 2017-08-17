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

/**
 * Class Gallery
 * @package Benkle\Deviantart\Endpoints
 */
class Gallery extends Endpoints
{
    /**
     * Fetch gallery folder contents.
     *
     * @param string|null $folderId
     * @param string|null $username
     * @param string $mode
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFolder(
        string $folderId = null,
        string $username = null,
        string $mode = Api::FOLDER_MODE_POPULAR,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/gallery/' . ($folderId ?? ''))
            ->setParameter('username', $username)
            ->setParameter('mode', $mode)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     *  Fetch gallery folders.
     *
     * You can preload up to 5 deviations from each folder by passing ext_preload parameter.
     * It is mainly useful to reduce number of requests to API.
     *
     * @param string|null $username
     * @param bool|null $calculateSize
     * @param bool|null $preload
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFolders(
        string $username = null,
        bool $calculateSize = null,
        bool $preload = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/gallery/folders')
            ->setParameter('username', $username)
            ->setParameter('calculate_size', $calculateSize)
            ->setParameter('ext_preload', $preload)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get the "all" view of a users gallery.
     *
     * @param string|null $username
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getAll(
        string $username = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/gallery/all')
            ->setParameter('username', $username)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Create new gallery folders.
     *
     * @param string $name
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function createFolder(
        string $name,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/gallery/folders/create')
            ->setMethod(ApiRequest::POST)
            ->setParameter('folder', $name)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Delete gallery folder.
     *
     * @param string $name
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function deleteFolder(
        string $folderId,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/gallery/folders/remove/' . $folderId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
