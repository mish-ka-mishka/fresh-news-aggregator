<?php

namespace App\Models;

use App\Models\Traits\HasPublicId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string $public_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $url
 * @property Carbon $published_at
 * @property ?string $author
 * @property ?string $cover_url
 * @property ?string $source
 * @property string $provider
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCoverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUrl($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use HasFactory, HasPublicId, Searchable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'url',
        'published_at',
        'author',
        'cover_url',
        'source',
        'provider',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'public_id';
    }

    public static function fromDto(\App\DTO\Article $articleDto): self
    {
        return new self([
            'title' => $articleDto->getTitle(),
            'description' => $articleDto->getDescription(),
            'content' => $articleDto->getContent(),
            'url' => $articleDto->getUrl(),
            'published_at' => $articleDto->getPublishedAt(),
            'author' => $articleDto->getAuthor(),
            'cover_url' => $articleDto->getCoverUrl(),
            'source' => $articleDto->getSource(),
            'provider' => $articleDto->getProvider(),
        ]);
    }

    public function updateFromDto(\App\DTO\Article $articleDto)
    {
        $this->title = $articleDto->getTitle();
        $this->description = $articleDto->getDescription();
        $this->content = $articleDto->getContent();
        $this->url = $articleDto->getUrl();
        $this->published_at = $articleDto->getPublishedAt();
        $this->author = $articleDto->getAuthor();
        $this->cover_url = $articleDto->getCoverUrl();
        $this->source = $articleDto->getSource();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    #[SearchUsingFullText(['description', 'content'])]
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'author' => $this->author,
            'source' => $this->source,
        ];
    }
}
