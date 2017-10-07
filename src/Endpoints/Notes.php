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

class Notes extends Endpoints
{
    const READ = 'read';
    const UNREAD = 'unread';
    const STARRED = 'starred';
    const NOT_STARRED = 'notstarred';
    const SPAM = 'spam';

    /**
     * Fetch notes.
     *
     * By default the endpoint fetches notes from Inbox folder.
     *
     * @param string|null $folderId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getNotes(
        string $folderId = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('folderid', $folderId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch note folders.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFolders(
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/folders';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Create new folder.
     *
     * @param string $title
     * @param string|null $parentId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function createFolder(
        string $title,
        string $parentId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/folders/create';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('title', $title)
            ->setParameter('parentid', $parentId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Rename a folder.
     *
     * @param string $folderId
     * @param string $newTitle
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function renameFolder(
        string $folderId,
        string $newTitle,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/folders/rename/' . $folderId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('title', $newTitle)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Delete note folder.
     *
     * @param string $folderId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function removeFolder(
        string $folderId,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/folders/remove/' . $folderId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Send a note.
     *
     * @param string[] $to
     * @param string|null $subject
     * @param string|null $body
     * @param string|null $answerTo
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function send(
        array $to,
        string $subject = null,
        string $body = null,
        string $answerTo = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/send';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('to', $to)
            ->setParameter('subject', $subject)
            ->setParameter('body', $body)
            ->setParameter('noteid', $answerTo)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Move notes to a folder.
     *
     * Moving notes to any of these folders is forbidden: Inbox, Unread, Starred, Draft, Spam.
     * If possible, use /notes/mark endpoint to do the move.
     *
     * @param string[] $noteIds
     * @param string $folderId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function move(
        array $noteIds,
        string $folderId,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/move';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('noteids', $noteIds)
            ->setParameter('folderid', $folderId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Mark notes.
     *
     * @param string[] $noteIds
     * @param string $mark
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function mark(
        array $noteIds,
        string $mark,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/mark';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('noteids', $noteIds)
            ->setParameter('mark_as', $mark)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch a single note.
     *
     * @param string $noteId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function get(
        string $noteId,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/' . $noteId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Delete a note or notes.
     *
     * @param string[] $noteIds
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function delete(
        array $noteIds,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/notes/delete';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('noteids', $noteIds)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
