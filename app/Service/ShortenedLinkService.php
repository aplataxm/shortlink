<?php

namespace App\Service;

use App\Model\User;
use App\Model\Link;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ShortenedLinkService
 * @package App\Service
 */
class ShortenedLinkService
{
    /**
     * @param array $attributes
     * @param User  $author
     *
     * @return Link
     */
    public function create(array $attributes, User $author)
    {
        $link = (new Link())->fill($attributes);
        $link->author()->associate($author);
        $link->save();

        return $link;
    }

    /**
     * @param Link $link
     *
     * @return Link
     */
    public function incrementCountOfViews(Link $link)
    {
        $link->increment('views_count');

        return $link;
    }

    /**
     * @param Link $link
     */
    public function delete(Link $link)
    {
        $link->delete();
    }

    /**
     * @param string $token
     *
     * @return Link
     */
    public function findByToken(string $token)
    {
        try{
            /** @var Link $link */
            $link = Link::where('token', $token)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundHttpException(sprintf('Link %s not found', url('shortened_link.follow', ['token' => $token])), $exception);
        }

        return $link;
    }

    /**
     * @param string $token
     *
     * @return Link|null
     */
    public function getLinkOrNullByToken(string $token)
    {
        return Link::where('token', $token)->first();
    }

    /**
     * @param int $id
     *
     * @return Link
     */
    public function findById(int $id)
    {
        try{
            /** @var Link $link */
            $link = Link::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            throw new NotFoundHttpException(sprintf('Link %s not found', $id), $exception);
        }

        return $link;
    }

    /**
     * @param User $user
     *
     * @return Collection
     */
    public function findByUser(User $user)
    {
        return Link::where('author_id', $user->id)->get();
    }
}
