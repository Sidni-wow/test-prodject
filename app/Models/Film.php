<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $title
 * @property string $image
 * @property int $position
 * @property string $description
 * @property Carbon|null $watch_soon_at
 * @property Carbon|null $published_at
 *
 * @method static Builder onlyPublished()
 * @method static Builder onlyWatchSoon()
 * @method static Builder onlyNotWatchSoon()
*/
class Film extends Model
{
    protected $table = 'films';

    protected $fillable = [
        'title', 'image', 'description', 'position', 'watch_soon_at', 'published_at'
    ];

    protected $dates = [
        'watch_soon_at',
        'published_at',
    ];

    public function getImageAttribute()
    {
        if (is_null($this->attributes['image'])) {
            return $this->attributes['image'];
        }

        return $this->attributes['image'] = Storage::disk(StaticFile::CLIENT_DISK)->url($this->attributes['image']);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyPublished(Builder $builder): Builder
    {
        return $builder->whereNotNull('published_at');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyWatchSoon(Builder $builder): Builder
    {
        return $builder->whereNotNull('watch_soon_at');
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOnlyNotWatchSoon(Builder $builder): Builder
    {
        return $builder->whereNull('watch_soon_at');
    }


    /**
     * @return $this|null
     */
    public function getBottom(): ?self
    {
        return $this->where('position', '<', $this->position)
            ->position()
            ->first()
            ;
    }

    /**
     * @return $this|null
     */
    public function getTop(): ?self
    {
        return $this->where('position', '>', $this->position)
            ->orderBy('position')
            ->first()
            ;
    }

    public function scopePosition(Builder $builder): Builder
    {
        return $builder->orderByDesc('position');
    }

    public function isPublished(): bool
    {
        return ! is_null($this->published_at);
    }
}
