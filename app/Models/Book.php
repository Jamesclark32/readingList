<?php

namespace App\Models;

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
        'first_published_at',
        'openlibrary_data_retrieved_at',
    ];

    public $dates = [
        'first_published_at',
        'openlibrary_data_retrieved_at',
    ];

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
