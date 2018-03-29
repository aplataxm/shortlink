<?php

namespace App\Http\Controllers\Link;

use App\Model\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShortenedLinkCreateRequest;
use App\Model\Link;
use App\Service\ShortenedLinkService;
use Illuminate\Support\Facades\Auth;

/**
 * Class ShortenedLinkController
 * @package App\Http\Controllers\Link
 */
class ShortenedLinkController extends Controller
{
    /**
     * @var ShortenedLinkService
     */
    protected $linkService;

    /**
     * LinkController constructor.
     *
     * @param ShortenedLinkService $linkService
     */
    public function __construct(ShortenedLinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    /**
     * @return $this
     */
    public function index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $links = $this->linkService->findByUser($currentUser);

        return view('shortened-link.index')->with('links', $links);
    }

    /**
     * @param ShortenedLinkCreateRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(ShortenedLinkCreateRequest $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $link = $this->linkService->create($request->getAttributes(), $currentUser);

        flash(sprintf('Link successfully shortened to %s', $link->shortened_url), 'success');

        return redirect()->route('links', ['link_id' => $link->id]);
    }

    /**
     * @param $linkId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($linkId)
    {
        $link = $this->linkService->findById($linkId);
        $this->guardCanEdit($link);
        $this->linkService->delete($link);

        flash(sprintf('Link %s successfully deleted', $link->shortened_url), 'success');

        return redirect()->route('links');
    }

    /**
     * @param Link $link
     */
    protected function guardCanEdit(Link $link)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        if ((int)$currentUser->id !== (int)$link->author->id)
        {
            abort(403, 'Permission denied');
        }
    }
}
