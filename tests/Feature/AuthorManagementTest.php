<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    //  This migrates the database before each test then tears down
    //  the database after the test that way you have a clean slate
    //  before each test
    //
    use RefreshDatabase;

    //----------------------------------------------------------------------------------------------
    //  TEST 1 - Ensure an author can be created
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function an_author_can_be_created()
    {
        //  Turn off exception handling so errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  This style of calling the private function for data is done
        //  so that in future array_merge() function may be used alongside
        //  $this->data() to override a single field if becomes is necessary
        //
        $this->post('/authors', $this->data());

        $author = Author::all();

        //  Assert Author count is 1 here to ensure author was created otherwise assertCount()
        //  test below may not be valid if Author was not created meaning count was 0 all along
        //
        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);

        //  Here we reformat the date to a different format to make sure it got parsed coorectly
        //
        $this->assertEquals('1980/20/05', $author->first()->dob->format('Y/d/m'));
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 2 - Ensure Validation with a name is required
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_name_is_required()
    {
        //  Turn off exception handling so errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  This style of calling the private function for data is done
        //  so that in future array_merge() function may be used alongside
        //  $this->data() to override a single field if becomes is necessary
        //
        //  We are invalidating the 'name' field in the data here
        //
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        //  Here we assert against the $response that the session has an error for
        //  'name' which is the key that we are looking for because thats what we are testing
        //
        $response->assertSessionHasErrors('name');
    }
    //----------------------------------------------------------------------------------------------

 
    //----------------------------------------------------------------------------------------------
    //  TEST 3 - Ensure Validation with a dob is required
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_dob_is_required()
    {
        //  Turn off exception handling so errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  This style of calling the private function for data is done
        //  so that in future array_merge() function may be used alongside
        //  $this->data() to override a single field if becomes is necessary
        //
        //  We are invalidating the 'dob' field in the data here
        //
        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        //  Here we assert against the $response that the session has an error for
        //  'dob' which is the key that we are looking for because thats what we are testing
        //
        $response->assertSessionHasErrors('dob');
    }
    //----------------------------------------------------------------------------------------------


    private function data()
    {
        return [
            'name' => 'Author Name',
            'dob' => '05/20/1980',
        ];
    }
}