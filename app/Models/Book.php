<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Book extends Model
{
    use HasFactory, HasSlug;

    public $fillable = [
        'slug',
        'isbn',
        'title',
        'author',
        'first_sentence',
        'read_statuses_id',
        'read_order',
        'first_published_at',
        'started_at',
        'completed_at',
        'added_at',
        'openlibrary_data_retrieved_at',
    ];

    public $dates = [
        'first_published_at',
        'started_at',
        'completed_at',
        'added_at',
        'openlibrary_data_retrieved_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // If a record is being created with a null added_at
            // Then set it to the current datetime
            if (!array_key_exists('added_at', $model->attributes) || $model->attributes['added_at'] == null) {
                $model->attributes['added_at'] = Carbon::now();
            }
        });
    }

    /**
     * Get the options for building the slug as described
     * by the included package spatie/laravel-sluggable
     *
     * @return SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
