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

class Stash extends Endpoints
{
    const MATURITY_LEVEL_STRICT   = 'strict';
    const MATURITY_LEVEL_MODERATE = 'moderate';

    const MATURITY_CLASSIFICATION_NUDITY    = 'nudity';
    const MATURITY_CLASSIFICATION_SEXUAL    = 'sexual';
    const MATURITY_CLASSIFICATION_GORE      = 'gore';
    const MATURITY_CLASSIFICATION_LANGUAGE  = 'language';
    const MATURITY_CLASSIFICATION_IDEAOLOGY = 'ideology';

    const LICENSE_CREATIVE_COMMONS = 1;
    const LICENSE_COMMERCIAL       = 2;
    const LICENSE_MODIFY           = 4;

    /**
     *  Submit files to Sta.sh or modify existing files
     *
     * This call requires one or more files to be sent as multipart/form-data.
     * It can receive files in any format. Some formats like JPG, PNG, GIF,
     * HTML or plain text can be viewed directly on Sta.sh and DeviantArt.
     * Other file types are made available for download and may have a preview image.
     *
     * Important, since version 20151014 this endpoint may use chunked response
     * encoding during upload of large files. This is to allow large uploads to work
     * with our CDN. Because of this errors may be returned with a 200 http code,
     * clients will need to check the response body for the standard error response
     * even if the http status is 200.
     *
     * @param string|null $title
     * @param string|null $comment
     * @param array|null $tags
     * @param string|null $originalUrl
     * @param bool|null $dirty
     * @param int|null $itemId
     * @param string|null $stack
     * @param int|null $stackId
     * @param bool|null $includeMature
     * @return ApiRequest
     * @throws \Exception
     */
    public function submit(
        string $title = null,
        string $comment = null,
        array $tags = null,
        string $originalUrl = null,
        bool $dirty = null,
        int $itemId = null,
        string $stack = null,
        int $stackId = null,
        bool $includeMature = null
    ): ApiRequest
    {
        $url = Api::URL . '/stash/submit';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('title', $title)
            ->setParameter('artist_comments', $comment)
            ->setParameter('tags', $tags)
            ->setParameter('original_url', $originalUrl)
            ->setParameter('is_dirty', $dirty)
            ->setParameter('itemid', $itemId)
            ->setParameter('stack', $stack)
            ->setParameter('stackid', $stackId)
            ->setParameter('mature_content', $includeMature);
        return $request;
    }

    /**
     *  Check how much sta.sh space a user has available for new uploads.
     *
     * This call returns JSON-encoded space values, expressed in bytes.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getSpace(bool $includeMature = null): \stdClass
    {
        $url = Api::URL . '/stash/space';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     *  Retrieve contents of Sta.sh for a user.
     *
     * This endpoint is used to retrieve all data available in user's Sta.sh.
     * The Sta.sh data is organized into stacks and items. A stack contains
     * either a list of children stacks or a single item, that is, a stack
     * can't contain more than one item or a mix of stacks and items.
     * Stacks can be moved into another stack or positioned within a parent.
     * An item represents a Sta.sh submission and is always contained within some stack.
     *
     * This endpoint is incremental. The first time you call it for a user, your app
     * will receive the full list of that user's Sta.sh stacks and items.
     * Your app should cache these results locally.
     *
     * Afterward, your app should then provide a cursor parameter for all /delta calls.
     * This cursor tells us which data you have already received so that we can send
     * you only new and modified stacks and items.
     *
     * @param string|null $cursor
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeSubmissionInfo
     * @param bool|null $includeExif
     * @param bool|null $includeStats
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getDelta(
        string $cursor = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeSubmissionInfo = null,
        bool $includeExif = null,
        bool $includeStats = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/delta';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('cursor', $cursor)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('ext_submission', $includeSubmissionInfo)
            ->setParameter('ext_camera', $includeExif)
            ->setParameter('ext_stats', $includeStats)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Delete a previously submitted file.
     *
     * @param string $itemId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function delete(
        string $itemId,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/delete';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('itemid', $itemId)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     *  Move the stack into the target stack
     *
     * The response includes updated metadata of the target stack and changes in
     * its contents. Changes include at least the stack being moved. If the move
     * operation resulted in new stacks being created, they will be returned as well.
     * New stack may be created if the target stack is a leaf stack,
     * i.e. has no children stacks yet.
     *
     * @param string $stackId
     * @param string|null $targetId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function moveStack(
        string $stackId,
        string $targetId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/move/' . $stackId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('targetid', $targetId)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     *  Publish a Sta.sh item to deviantART.
     *
     * @param string $itemId
     * @param bool $isMature
     * @param bool $agreedToSubmissionPolicy
     * @param bool $agreedToTOS
     * @param string|null $categoryPath
     * @param array|null $galleries
     * @param int|null $license
     * @param string|null $maturityLevel
     * @param array|null $maturityClassification
     * @param bool|null $allowComments
     * @param bool|null $allowDownload
     * @param bool|null $addWatermark
     * @param bool|null $requestCritiques
     * @param bool|null $feature
     * @param bool|null $sharing
     * @param int|null $displayResolution
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function publish(
        string $itemId,
        bool $isMature,
        bool $agreedToSubmissionPolicy,
        bool $agreedToTOS,
        string $categoryPath = null,
        array $galleries = null,
        int $license = null,
        string $maturityLevel = null,
        array $maturityClassification = null,
        bool $allowComments = null,
        bool $allowDownload = null,
        bool $addWatermark = null,
        bool $requestCritiques = null,
        bool $feature = null,
        bool $sharing = null,
        int $displayResolution = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/publish';
        if (isset($license)) {
            $license = [
                'creative_commons' => false || ($license & self::LICENSE_CREATIVE_COMMONS),
                'commercial'       => false || ($license & self::LICENSE_COMMERCIAL),
                'modify'           => $license & self::LICENSE_MODIFY ? 'yes' : 'no',
            ];
        }
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('itemid', $itemId)
            ->setParameter('is_mature', $isMature)
            ->setParameter('mature_level', $maturityLevel)
            ->setParameter('mature_classification', $maturityClassification)
            ->setParameter('agree_submission', $agreedToSubmissionPolicy)
            ->setParameter('agree_tos', $agreedToTOS)
            ->setParameter('catpath', $categoryPath)
            ->setParameter('feature', $feature)
            ->setParameter('allow_comments', $allowComments)
            ->setParameter('request_critique', $requestCritiques)
            ->setParameter('display_resolution', $displayResolution)
            ->setParameter('sharing', $sharing)
            ->setParameter('license_options', $license)
            ->setParameter('galleryids', $galleries)
            ->setParameter('allow_free_download', $allowDownload)
            ->setParameter('add_watermark', $addWatermark)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Fetch category information for publishing.
     *
     * @param string $catPath
     * @param string|null $fileType
     * @param bool|null $frequent
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getCategoryTree(
        string $catPath,
        string $fileType = null,
        bool $frequent = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/publish/categorytree';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('catpath', $catPath)
            ->setParameter('filetype', $fileType)
            ->setParameter('frequent', $frequent)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Fetch users data about features and agreements.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getUserData(
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/publish/userdata';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Change the position of a stack within its parent.
     *
     * @param string $stackId
     * @param int $position
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function changeStackPosition(
        string $stackId,
        int $position,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/position/' . $stackId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('position', $position)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Update the stash stack's details.
     *
     * @param string $stackId
     * @param string|null $title
     * @param string|null $description
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function update(
        string $stackId,
        string $title = null,
        string $description = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/update/' . $stackId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setMethod(ApiRequest::POST)
            ->setParameter('title', $title)
            ->setParameter('description', $description)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Fetch stash item's metadata.
     *
     * @param string $itemId
     * @param bool|null $includeSubmissionInfo
     * @param bool|null $includeExif
     * @param bool|null $includeStats
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getItem(
        string $itemId,
        bool $includeSubmissionInfo = null,
        bool $includeExif = null,
        bool $includeStats = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/item/' . $itemId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('ext_submission', $includeSubmissionInfo)
            ->setParameter('ext_camera', $includeExif)
            ->setParameter('ext_stats', $includeStats)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Fetch a stash stack's metadata.
     *
     * @param string $stackId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getStack(
        string $stackId,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/' . $stackId;
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }

    /**
     * Fetch stack contents.
     *
     * Send 0 as a stackid to list contents of a root stack.
     *
     * @param string $stackId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeSubmissionInfo
     * @param bool|null $includeExif
     * @param bool|null $includeStats
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getStackContent(
        string $stackId,
        int $offset = 0,
        int $limit = 10,
        bool $includeSubmissionInfo = null,
        bool $includeExif = null,
        bool $includeStats = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/stash/' . $stackId . '/contents';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('ext_submission', $includeSubmissionInfo)
            ->setParameter('ext_camera', $includeExif)
            ->setParameter('ext_stats', $includeStats)
            ->setParameter('mature_content', $includeMature);
        return $request->send();
    }
}
