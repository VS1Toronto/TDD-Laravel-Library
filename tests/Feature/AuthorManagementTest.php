<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $this->withoutExceptionHandling();

        $this->post('/author', [
            'name' => 'Author Name',
            'dob' => '05/20/1980',
        ]);

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


}
