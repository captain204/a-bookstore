<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;

class BooksTest extends TestCase
{

    use DatabaseMigrations;

    /**
    * @test
    * @watch
   */
  public function it_returns_an_book_as_a_resource_object()
  {
            $book = factory(Book::class)->create();
            $user = factory(User::class)->create();
            Passport::actingAs($user);
            $this->getJson('/api/v1/books/1', [
                    'accept' => 'application/vnd.api+json',
                    'content-type' => 'application/vnd.api+json',
            ])
            ->assertStatus(200)
            ->assertJson([
                    "data" => [
                    "id" => '1',
                    "type" => "books",
                    "attributes" => [
                    'title' => $book->title,
                    'description' => $book->description,
                    'publication_year' => $book->publication_year,
                    'created_at' => $book->created_at->toJSON(),
                    'updated_at' => $book->updated_at->toJSON(),
                ]
            ]
        ]);
  } 



  

}











?>