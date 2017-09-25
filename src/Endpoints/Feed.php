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
 * Class Feed
 * @package Benkle\Deviantart\Endpoints
 */
class Feed extends Endpoints
{
    /**
     * Fetch Notifications.
     *
     * @param string|null $cursor
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getNotifications(string $cursor = null, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/notifications')
            ->setParameter('cursor', $cursor)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch Watch Feed.
     *
     * @param string|null $cursor
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getHome(string $cursor = null, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/home')
            ->setParameter('cursor', $cursor)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch content related to a Watch event.
     *
     * Please see the documentation of the /feed/home endpoint on how to obtain bucket ids.
     *
     * @param string $bucketId
     * @param int|null $offset
     * @param int $limit
     * @param bool $includeMature
     * @return \stdClass
     */
    public function getBucket(string $bucketId, int $offset = 0, int $limit = 10, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/home/' . $bucketId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch Profile Feed.
     *
     * @param string|null $cursor
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getProfile(string $cursor = null, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/profile')
            ->setParameter('cursor', $cursor)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get feed settings.
     *
     * The include field tells what kinds of events are included in Watch Feed.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getSettings(bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/settings')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Change feed settings.
     *
     * @param array|null $include
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function updateSettings(array $include = null, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/feed/settings/update')
            ->setMethod(ApiRequest::POST)
            ->setParameter('include', $include)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
