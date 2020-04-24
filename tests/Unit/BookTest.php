<?php

namespace Tests\Unit;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
	//  This migrates the database before each test then tears down
	//  the database after the test that way you have a clean slate
	//  before each test
	//
    use RefreshDatabase;
    

    /** @test */
    public function an_author_id_is_recovered()
    {
        Book::firstOrCreate([
            'title' => 'A Cool Title',
            'author_id' => 1,
        ]);

        $this->assertCount(1, Book::all());
    }
}
