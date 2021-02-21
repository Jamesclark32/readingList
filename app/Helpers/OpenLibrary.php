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

        $matchingRecord = Arr::get($records, 0);
        foreach ($records as $record) {
            $titleMatches = $this->propertyContains($record, 'title', $title);
            $authorMatches = $this->propertyContains($record, 'author_name', $author);
            if ($titleMatches && $authorMatches) {
                $matchingRecord = $record;
            }
        }

        if ($matchingRecord) {
            $isbn = $this->getProperty($matchingRecord, 'isbn');

            $coverId = $this->getProperty($matchingRecord, 'cover_i');

            $coverImageUri = null;

            if ($coverId) {
                $coverImageUri = $this->fetchCover($coverId, $isbn);
            }

            $firstPublished = $this->getProperty($matchingRecord, 'publish_date');
            if ($firstPublished) {
                $firstPublished = Carbon::parse($firstPublished);
            }

            return [
                'isbn' => $isbn,
                'cover_image_uri' => $coverImageUri,
                'first_published_at' => $firstPublished,
            ];
        }
        return [];
    }

    public function fetchCover(string $coverId, string $isbn)
    {
        $coverUrl = 'https://covers.openlibrary.org/b/id/'.$coverId.'-L.jpg';
        $coverImageData = @file_get_contents($coverUrl);

        if ($coverImageData) {
            $coverImageUri = $this->getCoverImageUri($isbn);
            Storage::disk('local')->put('public/'.$coverImageUri, $coverImageData);
            return $coverImageUri;
        }
        return null;
    }

    protected function buildUrl(string $uri, array $parameters): string
    {
        return config('openlibrary.base_url').$uri.'?'.http_build_query($parameters);
    }

    protected function resolveUrl($url)
    {
        //@TODO: getting a 404 out of Guzzle for unknown reasons here.
        //using file_get_contents as temporary work around.
        return @json_decode(file_get_contents($url));
    }

    protected function propertyContains($object, $property, $value): bool
    {
        if (! property_exists($object, $property)) {
            return false;
        }
        $propertyValue = $object->$property;

        if (! is_array($propertyValue)) {
            $propertyValue = [$propertyValue];
        }

        $propertyValue = array_map('strtolower', $propertyValue);

        return (in_array(strtolower($value), $propertyValue));
    }

    protected function getProperty($object, $property)
    {
        if (! property_exists($object, $property)) {
            return null;
        }
        $data = $object->$property;

        if (is_array($data)) {
            $data = Arr::get($data, 0);
        }

        return $data;
    }

    protected function getCoverImageUri(string $isbn): string
    {
        return 'book-covers/'.$isbn.'.jpg';
    }

}