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

class Collections extends Endpoints
{
    /**
     * Fetch collection folder contents.
     *
     * @param string $folderId
     * @param string|null $username
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFolder(
        string $folderId,
        string $username = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/collections/' . $folderId)
            ->setParameter('username', $username)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Add deviation to favourites.
     *
     * You can add deviation to multiple collections at once. If you omit folderid parameter, it will be added to
     * Featured collection.
     * The favourites field contains total number of times this deviation was favourited after the fave event.
     * Users can fave their own deviations, when this happens the fave is not counted but the item is added to the
     * requested folder.
     *
     * @param string $deviationId
     * @param string[]|null $folderIds
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function fave(
        string $deviationId,
        array $folderIds = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/collections/fave')
            ->setParameter('deviationid', $deviationId)
            ->setParameter('folderid', $folderIds)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Remove deviation from favourites.
     *
     * You can remove deviation from multiple collections at once. If you omit folderid parameter,
     * it will be removed from Featured collection.
     * The favourites field contains total number of times this deviation was favourited after the unfave event.
     * If a user has faved their own deviation, unfave can be used to remove the deviation from a given folder.
     * Favorite counts are not affected if the deviation is owned by the user.
     *
     * @param string $deviationId
     * @param string[]|null $folderIds
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function unfave(
        string $deviationId,
        array $folderIds = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/collections/unfave')
            ->setParameter('deviationid', $deviationId)
            ->setParameter('folderid', $folderIds)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch collection folders.
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
    public function getFolders(string $username = null, bool $calculateSize = null, bool $preload = null, int $offset = 0, int $limit = 10, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/collections/folders')
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
     * Create new collection folder.
     *
     * @param string $folder
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function createFolder(string $folder, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/collections/folders/create')
            ->setParameter('folder', $folder)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Delete collection folder.
     *
     * @param string $folderId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function deleteFolder(string $folderId, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/collections/folders/remove/' . $folderId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
