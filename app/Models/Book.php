<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
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
        'cover_image_uri',
        'read_sequence',
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

    protected $dispatchesEvents = [
        'saving' => \App\Events\Models\Book\Saving::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // If a record is being created with a null added_at
            // Then set it to the current datetime
            if (Arr::get($model->attributes, 'added_at') == null) {
                $model->attributes['added_at'] = Carbon::now();
            }

            // If a record is being created with a null read_sequence
            // Then set it to the current max + 1
            // Good point to consider in any performance optimization as a query is being added to every create here.
            if (Arr::get($model->attributes, 'read_sequence', null) === null) {
                $maxReadOrder = DB::table('books')->max('read_sequence');
                $model->attributes['read_sequence'] = $maxReadOrder + 1;
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
