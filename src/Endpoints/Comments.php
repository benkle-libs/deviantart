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
 * Class Comments
 * @package Benkle\Deviantart\Endpoints
 */
class Comments extends Endpoints
{
    /**
     * Fetch comments posted on deviation.
     *
     * Use commentid parameter to fetch replies to a specific comment.
     * Hidden comments are included in the response since version 20150106
     * and will have their body replaced with a placeholder.
     *
     * @param string $deviationId
     * @param string|null $commentId
     * @param int|null $maxDepth
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function forDeviation(
        string $deviationId,
        string $commentId = null,
        int $maxDepth = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/comments/deviation/' . $deviationId)
            ->setParameter('commentid', $commentId)
            ->setParameter('maxdepth', $maxDepth)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     *  Fetch comments posted on user profile
     *
     * Please see the documentation of forDeviation endpoint.
     *
     * @param string $username
     * @param string|null $commentId
     * @param int|null $maxDepth
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function forProfile(
        string $username,
        string $commentId = null,
        int $maxDepth = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/comments/profile/' . $username)
            ->setParameter('commentid', $commentId)
            ->setParameter('maxdepth', $maxDepth)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch comments posted on status.
     *
     * Please see the documentation of forDeviation endpoint.
     *
     * @param string $statusId
     * @param string|null $commentId
     * @param int|null $maxDepth
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function forStatus(
        string $statusId,
        string $commentId = null,
        int $maxDepth = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/comments/status/' . $statusId)
            ->setParameter('commentid', $commentId)
            ->setParameter('maxdepth', $maxDepth)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch siblings of a comment.
     *
     * Context object includes parent comment (if any) and the commented item.
     *
     * @param string $commentId
     * @param bool|null $extItem
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getSiblings(
        string $commentId,
        bool $extItem = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/comments/' . $commentId . '/siblings')
            ->setParameter('ext_item', $extItem)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Post comment on a users profile.
     *
     * @param string $username
     * @param string $body
     * @param string|null $commentId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function postToProfile(
        string $username,
        string $body,
        string $commentId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/comments/post/profile/' . $username)
            ->setParameter('commentid', $commentId)
            ->setParameter('body', $body)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Post comment on a status.
     *
     * @param string $statusId
     * @param string $body
     * @param string|null $commentId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function postToStatus(
        string $statusId,
        string $body,
        string $commentId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/comments/post/status/' . $statusId)
            ->setParameter('commentid', $commentId)
            ->setParameter('body', $body)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Post comment on a deviation.
     *
     * @param string $deviationId
     * @param string $body
     * @param string|null $commentId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function postToDeviation(
        string $deviationId,
        string $body,
        string $commentId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/comments/post/deviation/' . $deviationId)
            ->setParameter('commentid', $commentId)
            ->setParameter('body', $body)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
