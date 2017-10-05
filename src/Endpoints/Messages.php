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
 * Class Messages
 * @package Benkle\Deviantart\Endpoints
 */
class Messages extends Endpoints
{
    const TYPE_COMMENTS = 'comments';
    const TYPE_REPLIES = 'replies';
    const TYPE_ACTIVITY = 'activity';

    /**
     * Fetch feedback messages.
     *
     * Messages can be fetched in a stacked (default) or flat mode.
     * In the stacked mode similar messages will be grouped together and the most recent one will be returned.
     * stackid can be used to fetch the rest of the messages in the stack.
     *
     * @param string $type
     * @param string|null $folderId
     * @param bool|null $stack
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFeedback(
        string $type,
        string $folderId = null,
        bool $stack = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/messages/feedback')
            ->setParameter('type', $type)
            ->setParameter('folderid', $folderId)
            ->setParameter('stack', $stack)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch messages in a stack.
     *
     * @param string|null $stackId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFeedbackFromStack(
        string $stackId = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/messages/feedback/' . $stackId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Delete a message or a message stack.
     *
     * @param string|null $folderId
     * @param string|null $messageId
     * @param string|null $stackId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function delete(
        string $folderId = null,
        string $messageId = null,
        string $stackId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/messages/delete')
            ->setParameter('folderid', $folderId)
            ->setParameter('messageid', $messageId)
            ->setParameter('stackid', $stackId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch mention messages.
     *
     * Messages can be fetched in a stacked (default) or flat mode. In the stacked mode similar messages will be
     * grouped together and the most recent one will be returned. stackid can be used to fetch the rest of the messages
     * in the stack.
     *
     * @param string|null $folderId
     * @param bool|null $stack
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getMentions(
        string $folderId = null,
        bool $stack = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/messages/mentions')
            ->setParameter('folderid', $folderId)
            ->setParameter('stack', $stack)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch messages in a stack.
     *
     * @param string|null $stackId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getMentionsFromStack(
        string $stackId = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/messages/mentions/' . $stackId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Feed of all messages.
     *
     * Messages can be fetched in a stacked (default) or flat mode. In the stacked mode similar messages will be
     * grouped together and the most recent one will be returned. stackid can be used to fetch the rest of the messages
     * in the stack.
     *
     * @param string|null $folderId
     * @param string|null $cursor
     * @param bool|null $stack
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getAll(
        string $folderId = null,
        string $cursor = null,
        bool $stack = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/messages/feed')
            ->setParameter('folderid', $folderId)
            ->setParameter('cursor', $cursor)
            ->setParameter('stack', $stack)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
