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
 * Class User
 * @package Benkle\Deviantart\Endpoints
 */
class User extends Endpoints
{
    const LEVEL_STUDENT = 1;
    const LEVEL_HOBBYIST = 2;
    const LEVEL_PROFESSIONAL = 3;

    const SPECIALTY_ARTISAN_CRAFT = 1;
    const SPECIALTY_DESIGN_INTERFACES = 2;
    const SPECIALTY_DIGITAL_ART = 3;
    const SPECIALTY_FILM_ANIMATION = 4;
    const SPECIALTY_LITERATURE = 5;
    const SPECIALTY_PHOTOGRAPHY = 6;
    const SPECIALTY_TRADITIONAL_ART = 7;
    const SPECIALTY_OTHER = 8;
    const SPECIALTY_VARIED = 9;

    /**
     * Fetch user info of authenticated user.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function whoAmI(bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/whoami')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch user info for given usernames.
     *
     * @param string[] $usernames
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function whoIs(array $usernames, bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/user/whois')
            ->setParameter('usernames', $usernames)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get the users list of friends.
     *
     * @param string|null $username
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getFriends(
        string $username = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/friends/' . ($username ?? ''))
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Watch a user.
     *
     * @param string $username
     * @param bool $friend
     * @param bool $deviations
     * @param bool $journals
     * @param bool $threads
     * @param bool $critiques
     * @param bool $scraps
     * @param bool $activity
     * @param bool $collections
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function watch(
        string $username,
        bool $friend,
        bool $deviations,
        bool $journals,
        bool $threads,
        bool $critiques,
        bool $scraps,
        bool $activity,
        bool $collections,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/user/friends/watch/' . $username)
            ->setParameter(
                'watch', [
                'friend'        => $friend,
                'deviations'    => $deviations,
                'journals'      => $journals,
                'forum_threads' => $threads,
                'critiques'     => $critiques,
                'scraps'        => $scraps,
                'activity'      => $activity,
                'collections'   => $collections,
            ]
            )
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Unwatch a user.
     *
     * @param string $username
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function unwatch(
        string $username,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/user/friends/unwatch/' . $username)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     *  Check if user is being watched by the given user.
     *
     * @param string $username
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function amIWatching(
        string $username,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/friends/watching/' . $username)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Search friends by username.
     *
     * @param string $query
     * @param string|null $username
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function findFriends(
        string $query,
        string $username = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/friends/search')
            ->setParameter('username', $username)
            ->setParameter('query', $query)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch the status.
     *
     * @param string $statusId
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getStatus(
        string $statusId,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/statuses/' . $statusId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    public function postStatus(
        string $body = null,
        string $parentId = null,
        string $relatedId = null,
        string $stashId = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/user/statuses/post')
            ->setParameter('body', $body)
            ->setParameter('id', $relatedId)
            ->setParameter('parentid', $parentId)
            ->setParameter('stashid', $stashId)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get User Statuses.
     *
     * @param string $username
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getStatuses(
        string $username,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/statuses/')
            ->setParameter('username', $username)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Retrieve the dAmn auth token required to connect to the dAmn servers.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getDamnToken(bool $includeMature = null): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/damntoken')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get user profile information.
     *
     * @param string $username
     * @param bool|null $includeCollections
     * @param bool|null $includeGalleries
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getProfile(
        string $username,
        bool $includeCollections = null,
        bool $includeGalleries = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/profile/' . $username)
            ->setParameter('ext_collections', $includeCollections)
            ->setParameter('ext_galleries', $includeGalleries)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     *  Update the users profile information
     *
     * Use the /data/countries endpoint to get a list of countries and their IDs.
     *
     * @param bool|null $isArtist
     * @param int|null $level
     * @param int|null $specialty
     * @param string|null $realName
     * @param string|null $tagLine
     * @param int|null $countryId
     * @param string|null $website
     * @param string|null $bio
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function updateProfile(
        bool $isArtist = null,
        int $level = null,
        int $specialty = null,
        string $realName = null,
        string $tagLine = null,
        int $countryId = null,
        string $website = null,
        string $bio = null,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setMethod(ApiRequest::POST)
            ->setUrl(Api::URL . '/user/profile/update')
            ->setParameter('user_is_artist', $isArtist)
            ->setParameter('artist_level', $level)
            ->setParameter('artist_specialty', $specialty)
            ->setParameter('real_name', $realName)
            ->setParameter('tagline', $tagLine)
            ->setParameter('countryid', $countryId)
            ->setParameter('website', $website)
            ->setParameter('bio', $bio)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Get the user's list of watchers.
     *
     * @param string $username
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getWatchers(
        string $username,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/user/watchers/' . $username)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
