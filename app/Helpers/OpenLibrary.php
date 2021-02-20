<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class OpenLibrary
{
    public function search(string $title, string $author): array
    {
        $url = $this->buildUrl('search.json', [
            'q' => strtolower($title),
            'author' => strtolower($author),
        ]);

        //@TODO: getting a 404 out of Guzzle for unknown reasons here.
        //using file_get_contents as temporary work around.
        $data = file_get_contents($url);

        $data = json_decode($data);
        $records = $data->docs;

        $firstRecord = Arr::get($records, 0);

        if ($firstRecord) {
            return [
                'isbn' => Arr::get($firstRecord->isbn, 0),
                'first_published_at' => Carbon::parse(Arr::get($firstRecord->publish_date, 0),),
            ];
        }
    }

    public function fetchCover(string $isbn, string $slug)
    {
        $url = 'https://openlibrary.org/api/books?bibkeys=ISBN:'.$isbn.'&format=json';
        $data = json_decode(file_get_contents($url));
        $elementName = 'ISBN:'.$isbn;
        if (property_exists($data->$elementName, 'thumbnail_url')) {
            $coverImageUrl = $data->$elementName->thumbnail_url;
            $coverImageUrl = str_replace('-S.jpg', '-M.jpg', $coverImageUrl);
            $coverImageData = file_get_contents($coverImageUrl);
            Storage::disk('local')->put('book-covers/'.$slug.'.jpg', $coverImageData);
        }
    }

    protected function buildUrl(string $uri, array $parameters): string
    {
        return config('openlibrary.base_url').$uri.'?'.http_build_query($parameters);
    }
}