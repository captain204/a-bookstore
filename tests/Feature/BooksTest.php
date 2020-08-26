<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BooksTest extends TestCase
{

    use DatabaseMigrations;

        /**
        *@test
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
        
        /**
        * @test
        * @watch
        */
        public function
        it_returns_all_books_as_a_collection_of_resource_objects()
        {
            $books = factory(Book::class, 3)->create();
            $user = factory(User::class)->create();
            Passport::actingAs($user);
            $this->get('/api/v1/books')->assertStatus(200)->assertJson([
                 "data"=>[
                                [
                                        "id" => '1',
                                        "type" => "books",
                                        "attributes" => [
                                            'title' => $books[0]->title,
                                            'description' => $books[0]->description,
                                            'publication_year' => $books[0]->publication_year,
                                            'created_at' => $books[0]->created_at->toJSON(),
                                            'updated_at' => $books[0]->updated_at->toJSON(),
                                    ]
                                ],

                                
                                [
                                    "id" => '2',
                                    "type" => "books",
                                    "attributes" => [
                                        'title' => $books[1]->title,
                                        'description' => $books[1]->description,
                                        'publication_year' => $books[1]->publication_year,
                                        'created_at' => $books[1]->created_at->toJSON(),
                                        'updated_at' => $books[1]->updated_at->toJSON(),
                                    ]
                                ],

                                
                                [
                                    "id" => '3',
                                    "type" => "books",
                                    "attributes" => [
                                        'title' => $books[2]->title,
                                        'description' => $books[2]->description,
                                        'publication_year' => $books[2]->publication_year,
                                        'created_at' => $books[2]->created_at->toJSON(),
                                        'updated_at' => $books[2]->updated_at->toJSON(),
                            
                                    ]

                                ],
                        ]
                ]);
        }


  

}











?>