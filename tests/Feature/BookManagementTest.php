<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class BookManagementTest extends TestCase
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

        //  Fetch the first book created for test
        //
        $book = Book::first();

        //  Commented out when redirect added as
        //
        //  $response->assertOk();

        $this->assertCount(1, Book::all());

        //  Once a book has been added redirect to the details 
        //  page or in other words the show view of that method
        //
        $response->assertRedirect($book->path());
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
        //  Turn off exception handling so errors can be read
        //
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Victor',
        ]);

        //  Fetch the first book created for test
        //
        $book = Book::first();

        //  The above is updated here
        //
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);        
    
        //  Once a single  record has been updated redirect to
        //  details page or in other words the show view of that method
        //
        //  *** WARNING ***     fresh() has to be used here with path() because we are calling 
        //                      it and working on it earlier whereas we need the original value 
        //                                   
        //
        $response->assertRedirect($book->fresh()->path());
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 5 - Ensure a book can be deleted
    // 

    /** @test */
    public function a_book_can_be_deleted()
    {
        //  Turn off exception handling so errors can be read
        //
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A Cool Title',
            'author' => 'Victor',
        ]);

        //------------------------------------------------------------------------------------------
        //  Fetch the first book created for test
        //
        $book = Book::first();

        //  Assert Book count is 1 here to ensure book was created otherwise assertCount()
        //  test below may not be valid if Book was not created meaning count was 0 all along
        //
        $this->assertCount(1, Book::all());
        //------------------------------------------------------------------------------------------

        //  The above is deleted here
        //
        $response = $this->delete($book->path());

        //  Assert that there are no books using all() method confirming delete
        //
        $this->assertCount(0, Book::all());

        //  Redirect to index method of books
        //
        $response->assertRedirect('/books');
    }
    //----------------------------------------------------------------------------------------------

}
