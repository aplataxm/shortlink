<?php

namespace App\Service;

use App\Service\ShortenedLinkService;

/**
 * Class ShortenedLinkGenerator
 * @package App\Service
 */
class ShortenedLinkGenerator
{

    /**
     * @var ShortenedLinkService
    */
    protected $linkService;

    /**
     * ShortenedLinkGenerator constructor.
     *
     * @param ShortenedLinkService $linkService
     */
    public function __construct(ShortenedLinkService $linkService)
    {
        $this->linkService = $linkService;
    }

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
        do {
            $token = substr(hash('sha256', $originalUrl . microtime()), 0, $tokenLength);
            $link  = $this->linkService->getLinkOrNullByToken($token);
        } while (null !== $link);

        return $token;
    }
}
