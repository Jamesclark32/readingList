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

        $data = $this->resolveUrl($url);
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
        $data = $this->resolveUrl($url);

        $coverImageData = $this->extractCoverImageUrlFromResponse($isbn, $data);

        if ($coverImageData) {
            Storage::disk('local')->put('book-covers/'.$slug.'.jpg', $coverImageData);
        }
    }

    protected function buildUrl(string $uri, array $parameters): string
    {
        return config('openlibrary.base_url').$uri.'?'.http_build_query($parameters);
    }

    protected function resolveUrl($url)
    {
        //@TODO: getting a 404 out of Guzzle for unknown reasons here.
        //using file_get_contents as temporary work around.
        return json_decode(file_get_contents($url));
    }

    protected function extractCoverImageUrlFromResponse(string $isbn, $data)
    {
        $elementName = 'ISBN:'.$isbn;

        if (property_exists($data->$elementName, 'thumbnail_url')) {
            $coverImageUrl = $data->$elementName->thumbnail_url;
            $coverImageUrl = str_replace('-S.jpg', '-M.jpg', $coverImageUrl);
            return file_get_contents($coverImageUrl);
        }
        return null;
    }
}