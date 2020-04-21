<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    //  This migrates the database before each test then tears down
    //  the database after the test that way you have a clean slate
    //  before each test
    //
    use RefreshDatabase;

    //----------------------------------------------------------------------------------------------
    //  TEST 1 - Ensure a book can be added to the library database
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        //  Turn off exception handling so errors can be read
        //
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Victor',
        ]);

        $response->assertOk();
        $this->assertCount(1, Book::all());

        //  Use this option if not importing model Book at top of file
        //
        //  $this->assertCount(1, \App\Book::all());
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 2 - Ensure Validation error for 'title' confirming title needed
    // 

    /** @test */
    public function a_title_is_required()
    {
        //  Commented out as it causes an error for this test
        //
        //  $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor',
        ]);

        $response->assertSessionHasErrors('title');
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 3 - Ensure Validation error fpr 'author' confirming author needed
    // 

    /** @test */
    public function an_author_is_required()
    {
        //  Commented out as it causes an error for this test
        //
        //  $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 4 - Ensure a book can be updated
    // 

    /** @test */
    public function a_book_can_be_updated()
    {
        //  Commented out as it causes an error for this test
        //
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        //  The above is updated here
        //
        $response = $this->patch('/books/'. $book->id, [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);        
    }
    //----------------------------------------------------------------------------------------------
}
