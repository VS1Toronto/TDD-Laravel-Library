<?php

namespace Tests\Feature;

use App\Author;
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

        //  Using private method data() for valid data
        //
        $response = $this->post('/books', $this->data());

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

        //  Alteration in code utilizing array_merge() precidence characteristics to
        //  get around difficulty of changing author column to author_id column in database
        //
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));
        
        $response->assertSessionHasErrors('author_id');
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

        //  Using private method data() for valid data
        //
        $response = $this->post('/books', $this->data());

        //  Fetch the first book created for test
        //
        $book = Book::first();

        //  The above is updated here
        //
        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title', Book::first()->title);

        //  3 used here because of the how many times the end point is hit in
        //  this test which creates multiple author_id examples as the test proceeds
        //
        $this->assertEquals(3, Book::first()->author_id);        
    
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

        //  Using private method data() for valid data
        //
        $response = $this->post('/books', $this->data());

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


    //----------------------------------------------------------------------------------------------
    //  TEST 6 - Ensure if a book is added a new Author is automatically added with it
    // 

    /** @test */
    public function if_a_book_is_added_an_author_is_added_automatically_with_it()
    {
        //  Turn off exception handling so errors can be read
        //
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'A Cool Title',
            'author_id' => 'Victor',
        ]);

        //------------------------------------------------------------------------------------------
        //  Fetch the first book created for test
        //
        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);

        //  As this database example is created for this test then an
        //  Author should also be created so a count of 1 is to be expected
        //
        $this->assertCount(1, Author::all());
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  PRIVATE METHOD RETURNING ARRAY OF VALID DATA FOR TESTS
    //
    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Victor',
        ];
    }
    //----------------------------------------------------------------------------------------------

}
