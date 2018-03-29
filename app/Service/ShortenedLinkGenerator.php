<?php

namespace App\Service;

/**
 * Class ShortenedLinkGenerator
 * @package App\Service
 */
class ShortenedLinkGenerator
{
    /**
     * Generate shortened url from token
     *
     * @param $token
     *
     * @return string
     */
    public function generateUrl($token): string
    {
        return route('shortened_link.follow', ['token' => $token]);
    }

    /**
     * Generates token from original url
     *
     * @param     $originalUrl
     * @param int $tokenLength
     *
     * @return string
     */
    public function generateToken($originalUrl, $tokenLength = 6): string
    {
        return substr(hash('sha256', $originalUrl . microtime()), 0, $tokenLength);
    }
}
