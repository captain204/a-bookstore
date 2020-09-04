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

        /**
        * @test
        * @watch
        */
        public function it_can_sort_books_by_title_through_a_sort_query_parameter()
        {
                $user = factory(User::class)->create();
                Passport::actingAs($user);
                $books = collect([
                    'Building an API with Laravel',
                    'Classes are our blueprints',
                    'Adhering to the JSON:API Specification',
                    ])->map(function($title){
                    return factory(Book::class)->create([
                    'title' => $title
                    ]);
                });
                $this->get('/api/v1/books?sort=title', [
                    'accept' => 'application/vnd.api+json',
                    'content-type' => 'application/vnd.api+json',
                ])->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '3',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Adhering to the JSON:API
                        Specification',
                        'description' => $books[2]->description,
                        'publication_year' => $books[2]->
                        publication_year,
                        'created_at' => $books[2]->created_at->toJSON(),
                        'updated_at' => $books[2]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Building an API with Laravel',
                        'description' => $books[0]->description,
                        'publication_year' => $books[0]->
                        publication_year,
                        'created_at' => $books[0]->created_at->toJSON(),
                        'updated_at' => $books[0]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '2',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Classes are our blueprints',
                        'description' => $books[1]->description,
                        'publication_year' => $books[1]->
                        publication_year,
                        'created_at' => $books[1]->created_at->toJSON(),
                        'updated_at' => $books[1]->updated_at->toJSON(),
                        ]
                    ],
                ]
                    
            ]);
        }

        /**
        * @test
        * @watch
        */
        public function it_can_paginate_books_through_a_page_query_parameter()
        {
                $user = factory(User::class)->create();
                Passport::actingAs($user);
                $books = factory(Book::class, 10)->create();
                $this->get('/api/v1/books?page[size]=5&page[number]=1', [
                    'accept' => 'application/vnd.api+json',
                    'content-type' => 'application/vnd.api+json',
                ])->assertStatus(200)->assertJson([
                "data" => [
                    [
                        "id" => '1',
                        "type" =>"books",
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
                    [
                        "id" => '4',
                        "type" => "books",
                        "attributes" => [
                        'title' => $books[3]->title,
                        'description' => $books[3]->description,
                        'publication_year' => $books[3]->publication_year,
                        'created_at' => $books[3]->created_at->toJSON(),
                        'updated_at' => $books[3]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '5',
                        "type" => "books",
                        "attributes" => [
                        'title' => $books[4]->title,
                        'description' => $books[4]->description,
                        'publication_year' => $books[4]->publication_year,
                        'created_at' => $books[4]->created_at->toJSON(),
                        'updated_at' => $books[4]->updated_at->toJSON(),
                        ]
                    ],
                ],
                'links' => [
                'first' => route('books.index', ['page[size]' => 5, '
                page[number]' => 1]),
                'last' => route('books.index', ['page[size]' => 5, 'page
                [number]' => 2]),
                'prev' => null,
                'next' => route('books.index', ['page[size]' => 5, 'page
                [number]' => 2]),
                ]
            ]);
        }

        /**
        * @test
        * @watch
        */
        public function it_can_sort_books_by_title_in_descending_order_through_a_sort_query_parameter()
        {
            $user = factory(User::class)->create();
            Passport::actingAs($user);
            $books = collect([
                'Building an API with Laravel',
                'Classes are our blueprints',
                'Adhering to the JSON:API Specification',
            ])->map(function($title){
                return factory(Book::class)->create([
                'title' => $title
                ]);
            });
            $this->get('/api/v1/books?sort=-title', [
                       'accept' => 'application/vnd.api+json',
                       'content-type' => 'application/vnd.api+json',
            ])->assertStatus(200)->assertJson([
            "data" => [
                        [
                        "id" => '2',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Classes are our blueprints',
                        'description' => $books[1]->description,
                        'publication_year' => $books[1]->
                        publication_year,
                        'created_at' => $books[1]->created_at->toJSON(),
                        'updated_at' => $books[1]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '1',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Building an API with Laravel',
                        'description' => $books[0]->description,
                        'publication_year' => $books[0]->publication_year,
                        'created_at' => $books[0]->created_at->toJSON(),
                        'updated_at' => $books[0]->updated_at->toJSON(),
                        ]
                    ],
                    [
                        "id" => '3',
                        "type" => "books",
                        "attributes" => [
                        'title' => 'Adhering to the JSON:API Specification',
                        'description' => $books[2]->description,
                        'publication_year' => $books[2]->publication_year,
                        'created_at' => $books[2]->created_at->toJSON(),
                        'updated_at' => $books[2]->updated_at->toJSON(),
                        ]
                    ],
                ]
            ]);
        }



        public function it_can_sort_books_by_multiple_attributes_through_a_sort_query_parameter()
        {
            $user = factory(User::class)->create();
            Passport::actingAs($user);
            $books = collect([
            'Building an API with Laravel',
            'Classes are our blueprints',
            'Adhering to the JSON:API Specification',
            ])->map(function($title){
                if($title === 'Building an API with Laravel'){
                        return factory(Book::class)->create([
                        'title' => $title,
                        'publication_year' => '2019',
                    ]);
                }
                return factory(Book::class)->create([
                    'title' => $title,
                    'publication_year' => '2018',
                ]);
            });
            $this->get('/api/v1/books?sort=publication_year,title', [
                'accept' => 'application/vnd.api+json',
                'content-type' => 'application/vnd.api+json',
            ])->assertStatus(200)->assertJson([
            "data" => [
                            [
                            "id" => '3',
                            "type" => "books",
                            "attributes" => [
                            'title' => 'Adhering to the JSON:API
                            Specification',
                            'description' => $books[2]->description,
                            'publication_year' => $books[2]->publication_year,
                            'created_at' => $books[2]->created_at->toJSON(),
                            'updated_at' => $books[2]->updated_at->toJSON(),
                            ]
                        ],
                        [
                            "id" => '2',
                            "type" => "books",
                            "attributes" => [
                            'title' => 'Classes are our blueprints',
                            'description' => $books[1]->description,
                            'publication_year' => $books[1]->
                            publication_year,
                            'created_at' => $books[1]->created_at->toJSON(),
                            'updated_at' => $books[1]->updated_at->toJSON(),
                            ]
                        ],
                        [
                            "id" => '1',
                            "type" => "books",
                            "attributes" => [
                            'title' => 'Building an API with Laravel',
                            'description' => $books[0]->description,
                            'publication_year' => $books[0]->
                            publication_year,
                            'created_at' => $books[0]->created_at->toJSON(),
                            'updated_at' => $books[0]->updated_at->toJSON(),
                            ]
                        ],















}











?>