<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorsCollection;

use Illuminate\Http\Request;

class BooksAuthorsRelatedController extends Controller
{
    public function index(Book $book)
    {
        return new AuthorsCollection($book->authors);
    }

    private function relations()
    {
        return [
        AuthorsResource::collection($this->whenLoaded('authors')),
        ];
    }

    public function with($request)
    {
        return [
            'included' => collect($this->relations())
            ->flatMap(function ($resource) use($request) {
            return $resource->toArray($request);
            })
        ];
    }

}
