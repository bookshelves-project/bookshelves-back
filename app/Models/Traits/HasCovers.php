<?php

namespace App\Models\Traits;

use App\Enums\MediaDiskEnum;
use App\Models\MediaExtended;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Manage cover with conversions with `spatie/laravel-medialibrary`.
 */
trait HasCovers
{
    use InteractsWithMedia;

    /** @mixin \Spatie\Cover\Manipulations */
    public function registerMediaConversions(Media $media = null): void
    {
        $formatThumbnail = config('image.covers.thumbnail');
        $formatStandard = config('image.covers.og');
        $formatSimple = config('image.covers.simple');

        if ('local' !== config('app.env')) {
            $this->addMediaConversion('thumbnail')
                ->crop(Manipulations::CROP_TOP, $formatThumbnail['width'], $formatThumbnail['height'])
                ->format(config('bookshelves.cover_extension'))
            ;

            $this->addMediaConversion('og')
                ->crop(Manipulations::CROP_CENTER, $formatStandard['width'], $formatStandard['height'])
                ->format('jpg')
            ;

            $this->addMediaConversion('simple')
                ->crop(Manipulations::CROP_CENTER, $formatSimple['width'], $formatSimple['height'])
                ->format('jpg')
            ;
        }
    }

    /**
     * Manage EPUB files with spatie/laravel-medialibrary.
     */
    public function getCoverBookAttribute(): ?MediaExtended
    {
        // @phpstan-ignore-next-line
        return $this->getMedia(MediaDiskEnum::cover->value)->first() ?? null;
    }

    /**
     * Get cover thumbnail with `spatie/laravel-medialibrary`
     * With config/bookshelves define format.
     */
    public function getCoverThumbnailAttribute(): string|null
    {
        return $this->getCover('thumbnail');
    }

    /**
     * Get cover OpenGraph with `spatie/laravel-medialibrary`
     * With JPG format for social.
     */
    public function getCoverOgAttribute(): string|null
    {
        return $this->getCover('og');
    }

    /**
     * Get cover simple with `spatie/laravel-medialibrary`
     * With JPG format for Catalog.
     */
    public function getCoverSimpleAttribute(): string|null
    {
        return $this->getCover('simple');
    }

    /**
     * Get cover original with `spatie/laravel-medialibrary`
     * With config/bookshelves define format.
     */
    public function getCoverOriginalAttribute(): string|null
    {
        return $this->getCover();
    }

    /**
     * Get cover main color with `spatie/laravel-medialibrary`
     * Use for placeholder during cover loading.
     */
    public function getCoverColorAttribute(): string|null
    {
        /** @var Media $media */
        $media = $this->getFirstMedia(MediaDiskEnum::cover->value);

        // @phpstan-ignore-next-line
        if ($color = $media?->getCustomProperty('color')) {
            return "#{$color}";
        }

        return '#ffffff';
    }

    private function getCover(string $collection = '', string $extension = ''): string
    {
        if (! $extension) {
            $extension = config('bookshelves.cover_extension');
        }
        $class_name = $this->getClassName(true);
        // fix crash if conversion not exist in spatie/laravel-medialibrary
        $cover = null;

        try {
            $cover = $this->getFirstMediaUrl(MediaDiskEnum::cover->value, $collection);
        } catch (\Throwable $th) {
        }

        return $cover ? $cover : config('app.url').'/assets/images/'.('authors' === $class_name ? 'no-author.webp' : 'no-cover.webp');
    }
}
