<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorTest extends TestCase
{
	//  This migrates the database before each test then tears down
	//  the database after the test that way you have a clean slate
	//  before each test
	//
	use RefreshDatabase;


    /** @test */
    public function only_name_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'John Doe',
        ]);

        $this->assertCount(1, Author::all());
    }
}
