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

    /** @var  string */
    private $type;

    /** @var  int */
    private $errorCode = 0;

    /** @var  string */
    private $description;

    const TYPE_INVALID_REQUEST    = 'invalid_request';
    const TYPE_UNAUTHORIZED       = 'unauthorized';
    const TYPE_UNVERIFIED_ACCOUNT = 'unverified_account';
    const TYPE_SERVER_ERROR       = 'server_error';
    const TYPE_VERSION_ERROR      = 'version_error';

    /**
     * ApiException constructor.
     * @param int $httpCode
     * @param string $errorBody
     */
    public function __construct(int $httpCode, string $errorBody)
    {
        $errorBody = json_decode($errorBody, true);
        $this->type = $errorBody['error'];
        $this->description = $errorBody['error_description'];
        $message = $errorBody['error'] . ': ' . $errorBody['error_description'];
        if (isset($errorBody['error_code'])) {
            $message .= " ({$errorBody['error_code']})";
            $this->errorCode = intval($errorBody['error_code'], 10);
        }
        parent::__construct($message, $httpCode);

        if (isset($errorBody['error_details'])) {
            $this->details = $errorBody['error_details'];
        }
    }

    /**
     * Get details map.
     *
     * @return \string[]
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * Get the error type.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Check if exception is of a specific error type.
     *
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool
    {
        return $this->type === $type;
    }

    /**
     * Check if the exception is for an invalid request.
     *
     * @return bool
     */
    public function isInvalidRequest(): bool
    {
        return $this->is(self::TYPE_INVALID_REQUEST);
    }

    /**
     * Check if the exception is for an unauthorized request.
     *
     * @return bool
     */
    public function isUnauthorized(): bool
    {
        return $this->is(self::TYPE_UNAUTHORIZED);
    }

    /**
     * Check if the exception is for an unverified account.
     *
     * @return bool
     */
    public function isUnverifiedAccount(): bool
    {
        return $this->is(self::TYPE_UNVERIFIED_ACCOUNT);
    }

    /**
     * Check if the exception is for a server error.
     *
     * @return bool
     */
    public function isServerError(): bool
    {
        return $this->is(self::TYPE_SERVER_ERROR);
    }

    /**
     * Check if the exception is for a version error.
     *
     * @return bool
     */
    public function isVersionError(): bool
    {
        return $this->is(self::TYPE_VERSION_ERROR);
    }

    /**
     * Check if the exception is for rate limitation.
     *
     * @return bool
     */
    public function isRateLimited(): bool
    {
        return $this->getCode() === 429;
    }

    /**
     * Get the error code.
     *
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    /**
     * Get the error description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
