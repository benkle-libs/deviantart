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


namespace Benkle\Deviantart\Exceptions;

/**
 * Class ApiException
 * @package Benkle\Deviantart\Exceptions
 */
class ApiException extends \Exception
{
    /** @var  string[] */
    private $details = [];

    /**
     * ApiException constructor.
     * @param int $httpCode
     * @param string $errorBody
     */
    public function __construct(int $httpCode, string $errorBody)
    {
        $errorBody = json_decode($errorBody, true);
        $message = $errorBody['error'] . ': ' . $errorBody['error_description'];
        if (isset($errorBody['error_code'])) {
            $message .= " ({$errorBody['error_code']})";
        }
        parent::__construct(
            $message,
            $httpCode
        );

        if (isset($errorBody['error_details'])) {
            $this->details = $errorBody['error_details'];
        }
    }

    /**
     * Get details map.
     * @return \string[]
     */
    public function getDetails(): array
    {
        return $this->details;
    }
}
