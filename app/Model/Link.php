<?php

namespace App\Model;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Link
 * @package App\Model
 *
 * @property int    $id
 * @property User   $author
 * @property string $original_url
 * @property string $shortened_url
 * @property string $views_count
 */
class Link extends Model
{
    /**
     * @var string
     */
    protected $table = 'shortened_links';

    /**
     * @var array
     */
    protected $fillable = [
        'original_url',
        'shortened_url',
        'views_count',
        'token',
    ];

    protected $attributes = [
        'views_count' => 0,
    ];

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }
}
