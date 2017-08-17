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

/**
 * Class Browse
 * @package Benkle\Deviantart\Endpoints
 */
class Browse extends Endpoints
{

    /**
     * Fetch MoreLikeThis result for a seed deviation.
     *
     * @param string $seed
     * @param string|null $category
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getMoreLikeThis(
        string $seed,
        string $category = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/morelikethis';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('seed', $seed)
            ->setParameter('category', $category)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch More Like This preview result for a seed deviation.
     *
     * @param string $seed
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getMoreLikeThisPreview(
        string $seed,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/morelikethis/preview';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('seed', $seed)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse daily deviations.
     *
     * @param \DateTime $date
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getDailyDeviations(
        \DateTime $date = null,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/dailydeviations';
        $date = $date ?? new \DateTime();
        $date = $date->format('Y-m-d');
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('date', $date)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse a tag.
     *
     * @param string $tag
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getTag(
        string $tag,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/tags';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('tag', $tag)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Autocomplete tags.
     *
     * The tag_name parameter should not contain spaces.
     * If it does, spaces will be stripped and remainder will be treated as a single tag.
     *
     * @param string $tagName
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function searchTags(
        string $tagName,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/tags/search';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('tag_name', $tagName)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse journals of a user.
     *
     * @param string $username
     * @param bool|null $featured
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getUserJournals(
        string $username,
        bool $featured = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/user/journals';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('username', $username)
            ->setParameter('featured', $featured)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse newest deviations.
     *
     * @param string|null $categoryPath
     * @param string|null $query
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getNewest(
        string $categoryPath = null,
        string $query = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/newest';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('category_path', $categoryPath)
            ->setParameter('q', $query)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse popular deviations.
     *
     * @param string|null $categoryPath
     * @param string|null $query
     * @param string $timeRange
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getPopular(
        string $categoryPath = null,
        string $query = null,
        string $timeRange = Api::TIMERANGE_8_HR,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/popular';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('category_path', $categoryPath)
            ->setParameter('q', $query)
            ->setParameter('timerange', $timeRange)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse whats hot deviations.
     *
     * @param string|null $categoryPath
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getHot(
        string $categoryPath = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/hot';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('category_path', $categoryPath)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Browse undiscovered deviations.
     *
     * @param string|null $categoryPath
     * @param int $offset
     * @param int $limit
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getUndiscovered(
        string $categoryPath = null,
        int $offset = 0,
        int $limit = 10,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/undiscovered';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('category_path', $categoryPath)
            ->setParameter('offset', $offset)
            ->setParameter('limit', $limit)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Fetch category information for browsing.
     *
     * @param string $categoryPath
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getCategoryTree(
        string $categoryPath,
        bool $includeMature = null
    ): \stdClass
    {
        $url = Api::URL . '/browse/categorytree';
        $request = $this->api->newRequest();
        $request
            ->setUrl($url)
            ->setParameter('catpath', $categoryPath)
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
