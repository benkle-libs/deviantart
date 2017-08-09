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
 * Class Deviation
 * @package Benkle\Deviantart\Endpoints
 */
class Deviation extends Endpoints
{
    /**
     * Fetch a deviation.
     *
     * @param string $deviationId
     * @return \stdClass
     */
    public function getDeviation(string $deviationId): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/' . $deviationId)
        ;
        return $request->send();
    }

    /**
     *  Fetch full data that is not included in the main devaition object.
     *
     * The endpoint works with journals and literatures. Deviation objects returned from API contain only excerpt of a
     * journal, use this endpoint to load full content. Any custom CSS rules and fonts applied to journal are also
     * returned.
     *
     * @param string $deviationId
     * @param bool $includeMature
     * @return \stdClass
     */
    public function getContent(string $deviationId, bool $includeMature = null): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/content')
            ->setParameter('deviationid', $deviationId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get the original file download (if allowed).
     *
     * @param string $deviationId
     * @param bool $includeMature
     * @return \stdClass
     */
    public function getDownloadInfo(string $deviationId, bool $includeMature = null): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/download/' . $deviationId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch content embedded in a deviation
     *
     * Journal and literature deviations support embedding of deviations inside them.
     *
     * @param string $deviationId
     * @param string|null $offsetDeviationId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getEmbeddedContent(
        string $deviationId,
        string $offsetDeviationId = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/embeddedcontent')
            ->setParameter('deviationid', $deviationId)
            ->setParameter('offset_deviationid', $offsetDeviationId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch a list of users who faved the deviation.
     *
     * The list isn't ordered in any particular way.
     *
     * @param string $deviationId
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getWhoFaved(
        string $deviationId,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/whofaved')
            ->setParameter('deviationid', $deviationId)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch deviation metadata for a set of deviations.
     *
     * This endpoint is limited to 50 deviations per query when fetching
     * the base data and 10 when fetching extended data.
     *
     * @param string[] $deviationIds
     * @param bool|null $includeSubmissionInfo
     * @param bool|null $includeExif
     * @param bool|null $includeStats
     * @param bool|null $includeCollection
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getMetadata(
        array $deviationIds,
        bool $includeSubmissionInfo = null,
        bool $includeExif = null,
        bool $includeStats = null,
        bool $includeCollection = null,
        bool $includeMature = null): \stdClass
    {
        $request = new ApiRequest($this->api->getProvider(), $this->api->getAccessToken());
        $request
            ->setUrl(Api::URL . '/deviation/metadata')
            ->setParameter('deviationids', $deviationIds)
            ->setParameter('ext_submission', $includeSubmissionInfo)
            ->setParameter('ext_camera', $includeExif)
            ->setParameter('ext_stats', $includeStats)
            ->setParameter('ext_collection', $includeCollection)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
