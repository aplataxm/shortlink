<?php

namespace App\Http\Controllers\Link;

use App\Http\Controllers\Controller;
use App\Service\ShortenedLinkService;
use Illuminate\Http\RedirectResponse;

/**
 * Class FollowShortenedLinkController
 * @package App\Http\Controllers\Link
 */
class FollowShortenedLinkController extends Controller
{
    /**
     * @var ShortenedLinkService
     */
    protected $linkService;

    /**
     * FollowShortenedLinkController constructor.
     *
     * @param ShortenedLinkService $linkService
     */
    public function __construct(ShortenedLinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * @param string $token
     *
     * @return RedirectResponse
     */
    public function followLink(string $token)
    {
        $link = $this->linkService->findByToken($token);
        $this->linkService->incrementCountOfViews($link);

        return redirect()->to($link->original_url);
    }
}
