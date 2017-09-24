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


use Benkle\Deviantart\Endpoints\Browse;
use Benkle\Deviantart\Endpoints\Collections;
use Benkle\Deviantart\Endpoints\Comments;
use Benkle\Deviantart\Endpoints\Deviation;
use Benkle\Deviantart\Endpoints\Feed;
use Benkle\Deviantart\Endpoints\Gallery;
use Benkle\Deviantart\Endpoints\User;
use Benkle\Deviantart\Endpoints\Utils;
use Benkle\Deviantart\Exceptions\UnauthorizedException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;

/**
 * Class Api
 * @package Benkle\Deviantart
 */
class Api
{
    const URL = 'https://www.deviantart.com/api/v1/oauth2';

    const SCOPE_USER         = 'user';
    const SCOPE_USER_MANAGE  = 'user.manage';
    const SCOPE_BROWSE       = 'browse';
    const SCOPE_MORELIKETHIS = 'browse.mlt';
    const SCOPE_GALLERY      = 'gallery';
    const SCOPE_COLLECTION   = 'collection';
    const SCOPE_COMMENT_POST = 'comment.post';
    const SCOPE_FEED         = 'feed';
    const SCOPE_MESSAGE      = 'message';
    const SCOPE_NOTE         = 'note';
    const SCOPE_STASH        = 'stash';
    const SCOPE_PUBLISH      = 'publish';

    const FOLDER_MODE_POPULAR = 'popular';
    const FOLDER_MODE_NEWEST  = 'newest';

    const TIMERANGE_8_HR     = '8hr';
    const TIMERANGE_24_HR    = '24hr';
    const TIMERANGE_3_DAYS   = '3days';
    const TIMERANGE_1_WEEK   = '1week';
    const TIMERANGE_1_MONTH  = '1month';
    const TIMERANGE_ALL_TIME = 'alltime';

    /** @var  AbstractProvider */
    private $provider;

    /** @var  AccessToken */
    private $accessToken;

    /** @var  Gallery */
    private $gallery;

    /** @var  Deviation */
    private $deviation;

    /** @var  Feed */
    private $feed;

    /** @var  Browse */
    private $browse;

    /** @var  Utils */
    private $utils;

    /** @var  Collections */
    private $collections;

    /** @var  Comments */
    private $comments;

    /** @var  ApiRequest */
    private $requestPrototype;

    /**
     * Api constructor.
     *
     * @param AbstractProvider $provider
     * @param AccessToken|null $accessToken
     */
    public function __construct(AbstractProvider $provider, AccessToken $accessToken = null)
    {
        $this->provider = $provider;
        $this->accessToken = $accessToken;

        if ($accessToken) {
            $this->refreshRequestPrototype();
        }

        $this->gallery = new Gallery($this);
        $this->deviation = new Deviation($this);
        $this->feed = new Feed($this);
        $this->browse = new Browse($this);
        $this->utils = new Utils($this);
        $this->collections = new Collections($this);
        $this->comments = new Comments($this);
    }

    private function refreshRequestPrototype()
    {
        $this->requestPrototype = new ApiRequest($this->provider, $this->accessToken);
    }

    /**
     * Get the OAuth2 provider.
     *
     * @return AbstractProvider
     */
    public function getProvider(): AbstractProvider
    {
        return $this->provider;
    }

    /**
     * Get the access token.
     *
     * @return AccessToken
     */
    public function getAccessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * Create a new request.
     *
     * @return ApiRequest
     */
    public function newRequest(): ApiRequest
    {
        return clone $this->requestPrototype;
    }

    /**
     * Get the gallery endpoints.
     *
     * @return Gallery
     */
    public function gallery(): Gallery
    {
        return $this->gallery;
    }

    /**
     * Get the deviation endpoints.
     *
     * @return Deviation
     */
    public function deviation(): Deviation
    {
        return $this->deviation;
    }

    /**
     * Get the feed endpoints.
     *
     * @return Feed
     */
    public function feed(): Feed
    {
        return $this->feed;
    }

    /**
     * Get the browse endpoints.
     *
     * @return Browse
     */
    public function browse(): Browse
    {
        return $this->browse;
    }

    /**
     * Get the utils endpoints.
     *
     * @return Utils
     */
    public function utils(): Utils
    {
        return $this->utils;
    }

    /**
     * Get the collections endpoints.
     *
     * @return Collections
     */
    public function collections(): Collections
    {
        return $this->collections;
    }

    /**
     * Get the comments endpoints.
     * @return Comments
     */
    public function comments(): Comments
    {
        return $this->comments;
    }

    /**
     * Refresh access token.
     */
    public function refreshToken()
    {
        $this->accessToken = $this->provider->getAccessToken(
            'refresh_token', [
                               'refresh_token' => $this->accessToken->getRefreshToken(),
                           ]
        );
        $this->refreshRequestPrototype();
    }

    /**
     * Takes care of the authorization.
     *
     * Call this with the scopes you want, and if you got the auth code, that as well.
     * This method will either get the auth token, throw an exception with the auth url, or refresh the auth token if
     * needed.
     * @param string[] $scopes
     * @param string|null $authCode
     * @throws UnauthorizedException
     */
    public function authorize($scopes = [self::SCOPE_USER], string $authCode = null)
    {
        if (isset($authCode)) {
            $this->accessToken = $this->provider->getAccessToken(
                'authorization_code',
                ['code' => $authCode, 'scope' => $scopes,]
            );
            $this->refreshRequestPrototype();
        } elseif (!isset($this->accessToken)) {
            throw new UnauthorizedException($this->provider->getAuthorizationUrl(['scope' => $scopes]));
        } elseif ($this->accessToken->hasExpired()) {
            $this->refreshToken();
        }
    }
}
