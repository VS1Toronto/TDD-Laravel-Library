<?php

namespace Tests\Feature;

use App\Book;
use App\Reservation;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookCheckoutTest extends TestCase
{
    //  This migrates the database before each test then tears down
    //  the database after the test that way you have a clean slate
    //  before each test
    //
    use RefreshDatabase;

    //----------------------------------------------------------------------------------------------
    //  TEST 1 - Ensure a book can be checked out by a signed in user
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_book_can_be_checked_out_by_a_signed_in_user()
    {
        //  Turn off exception handling so errors can be read
        //
        $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a factory then use the User Class to create a new User
        //  then Hit the   /checkout/   end point using the $book created above
        //  to pass the book id
        //
        $this->actingAs($user = factory(User::class)->create())     //  Inline way of adding $user
            ->post('/checkout/' . $book->id);


        //  CHECKOUT ASSERTIONS
        //

        //  If Book is checked out Assert that in the Reservations table in the
        //  database that if we dump all the resevation records there should be 1
        //
        $this->assertCount(1, Reservation::all());

        //  If first Book reservation record is checked then the user_id for that record
        //  should belong to or in other words Equal the user_id of the current operating User
        //
        $this->assertEquals($user->id, Reservation::first()->user_id);

        //  If first Book reservation record is checked then the book_id for that record
        //  should belong to or in other words Equal the book_id of the current Book record
        //
        $this->assertEquals($book->id, Reservation::first()->book_id);

        //  If first Book reservation record is checked then the timestamp for that record should
        //  Equal the book checked_out_at field of the current Book record as its just been created
        //
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 2 - Ensure only signed in users can checkout a book
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function only_signed_in_users_can_checkout_a_book()
    {
        //  Turn on exception handling so 500 errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Hit the   /checkout/   end point to have it
        //  redirect you to login because your not logged in
        //
        $this->post('/checkout/' . $book->id)
            ->assertRedirect('/login');


        //  CHECKOUT ASSERTIONS
        //

        //  Assert there are no records in the Reservation table as there should not
        //  be as the user should not be able to check a book out without being logged in
        //
        $this->assertCount(0, Reservation::all());
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 3 - Ensure only a real book can be checked out
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function only_real_books_can_be_checked_out()
    {
        //  Turn on exception handling so 404 errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a factory then use the User Class to create a new User
        //  then Hit the   /checkout/123   end point and assert that there
        //  is a 404 error because that end point does not exist
        //
        $this->actingAs($user = factory(User::class)->create())     //  Inline way of adding $user
            ->post('/checkout/123')
            ->assertStatus(404);

        //  CHECKOUT ASSERTIONS
        //

        //  Assert there are no records in the Reservation table as there should not
        //  be as the user should not be able to check a book out without being logged in
        //
        $this->assertCount(0, Reservation::all());
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 4 - Ensure a book can be checked in by a signed in user
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_book_can_be_checked_in_by_a_signed_in_user()
    {
        //  Turn off exception handling so errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();

        //  Create a factory then use the User Class to create a new User
        //  then Hit the   /checkout/   end point using the $book created above
        //  to pass the book id
        //
        $this->actingAs($user)
            ->post('/checkout/' . $book->id);


        //  CHECKOUT ASSERTIONS
        //

        //  If Book is checked out Assert that in the Reservations table in the
        //  database that if we dump all the resevation records there should be 1
        //
        $this->assertCount(1, Reservation::all());

        //  If first Book reservation record is checked then the user_id for that record
        //  should belong to or in other words Equal the user_id of the current operating User
        //
        $this->assertEquals($user->id, Reservation::first()->user_id);

        //  If first Book reservation record is checked then the book_id for that record
        //  should belong to or in other words Equal the book_id of the current Book record
        //
        $this->assertEquals($book->id, Reservation::first()->book_id);

        //  If first Book reservation record is checked then the timestamp for that record should
        //  Equal the book checked_out_at field of the current Book record as its just been created
        //
        $this->assertEquals(now(), Reservation::first()->checked_out_at);


        //------------------------------------------------------------------------------------------
        //  Check Book back in to further test
        //  

        //  After the User object is created with the factory in the previous steps above 
        //  then use the User Class to create a new User then Hit the   /checkin/   end point 
        //  using the $book created in the previous steps above to pass the book id
        //
        $this->actingAs($user)
            ->post('/checkin/' . $book->id);

        //  Extra tests on Book checked in - asserNotNull - checked_in_at
        //
        $this->assertNotNull(Reservation::all()->last()->checked_in_at);
       
        //  If first Book reservation record is checked then the timestamp for that record should
        //  Equal the book checked_in_at field of the current Book record as its just been created
        //
        $this->assertEquals(now(), Reservation::all()->last()->checked_in_at);
        //------------------------------------------------------------------------------------------
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 5 - Ensure only signed in users can checkin a book
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function only_signed_in_users_can_checkin_a_book()
    {
        //  Turn on exception handling so 500 errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Setup test with authenticated user so that the 
        //  checkin step can be tested for next
        //
        //  Hit the   /checkout/   end point to have it
        //  redirect you to login because your not logged in
        //
        $this->actingAs(factory(User::class)->create())
            ->post('/checkout/' . $book->id);


        //  Use Auth to logout so that all previous login actions
        //  are removed so that the checkin step can be tested
        //
        Auth::logout();

        //  Hit the   /checkout/   end point to have it
        //  redirect you to login because your not logged in
        //
        $this->post('/checkin/' . $book->id)
            ->assertRedirect('/login');


        //  CHECKIN ASSERTIONS
        //

        //  Assert there are is a record in the Reservation table as there should be 
        //  as the user should not be able to check a book in without being logged in
        //
        $this->assertCount(1, Reservation::all());

        //  Assert Book check in at time is null
        //
        $this->assertNull(Reservation::all()->last()->checked_in_at);
    }
    //----------------------------------------------------------------------------------------------






    






    //----------------------------------------------------------------------------------------------
    //  TEST 6 - Ensure a 404 is thrown if a book is not checked out first
    // 

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_404_is_thrown_if_a_book_is_not_checked_out_first()
    {
        //  Turn on exception handling so 404 errors can be read
        //
        //  $this->withoutExceptionHandling();

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();

        //  Hit the   /checkin/   end point even though there
        //  has been no book checked out to create the 404 error
        //
        $this->actingAs($user)
            ->post('/checkin/' . $book->id)
            ->assertStatus(404);


        //  CHECKIN ASSERTIONS
        //

        //  Assert there are is no records in the Reservation table as the user
        //  should not be able to check a book in without it first being checked out
        //
        $this->assertCount(0, Reservation::all());
    }
    //----------------------------------------------------------------------------------------------

}
