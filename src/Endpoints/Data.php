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
 * Class Data
 * @package Benkle\Deviantart\Endpoints
 */
class Data extends Endpoints
{
    /**
     * Get a list of countries.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getCountries(
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/data/countries')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Returns the DeviantArt Terms of Service.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getTermsOfService(
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/data/tos')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Returns the DeviantArt Privacy Policy.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getPrivacyPolicy(
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/data/privacy')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }

    /**
     * Returns the DeviantArt Submission Policy.
     *
     * @param bool|null $includeMature
     * @return \stdClass
     */
    public function getSubmissionPolicy(
        bool $includeMature = null
    ): \stdClass
    {
        $request = $this->api->newRequest();
        $request
            ->setUrl(Api::URL . '/data/submission')
            ->setParameter('mature_content', $includeMature)
        ;
        return $request->send();
    }
}
