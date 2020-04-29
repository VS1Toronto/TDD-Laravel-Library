<?php

namespace Tests\Unit;

use App\Book;
use App\Reservation;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationsTest extends TestCase
{
    //  This migrates the database before each test then tears down
    //  the database after the test that way you have a clean slate
    //  before each test
    //
    use RefreshDatabase;

    //----------------------------------------------------------------------------------------------
    //  TEST 1 - Ensure a book can checked out
    //

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_book_can_be_checked_out()
    {
        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();
        
        //  A Book can have a checkout method called on it passing in a user
        //
        //  This method will be added to the Book Model
        //
        //  The authenticated user is not used here in case there is a use
        //  case where a librarian may be able to check out a book for another user
        //
        $book->checkout($user);

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
    //  TEST 2 - Ensure a book can be returned and checked in
    //

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_book_can_be_returned_and_checked_in()
    {
        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();

        //  A Book can have a checkout method called on it passing in a user
        //
        //  This method will be added to the Book Model
        //
        //  The authenticated user is not used here in case there is a use
        //  case where a librarian may be able to check out a book for another user
        //
        $book->checkout($user);
        
        //  A Book can have a checkin method called on it passing in a user
        //
        //  This method will be added to the Book Model
        //
        //  The authenticated user is not used here in case there is a use
        //  case where a librarian may be able to check out a book for another user
        //
        $book->checkin($user);

        //  CHECKIN ASSERTIONS
        //

        //  If Book is checked out Assert that in the Reservations table in the
        //  database that if we dump all the resevation records there should be 1
        //
        $this->assertCount(1, Reservation::all());

        //------------------------------------------------------------------------------------------
        //  These assertions are not necessary due to them already being asserted in the TEST 1
        //  a_book_can_be_checked_out()   method above but they are being asserted again just to
        //  ensure that the code does not accidentally override the book_id or the user_id during
        //  the book being checked in
        //
        //  If first Book reservation record is checked then the user_id for that record
        //  should belong to or in other words Equal the user_id of the current operating User
        //
        $this->assertEquals($user->id, Reservation::first()->user_id);

        //  If first Book reservation record is checked then the book_id for that record
        //  should belong to or in other words Equal the book_id of the current Book record
        //
        $this->assertEquals($book->id, Reservation::first()->book_id);
        //------------------------------------------------------------------------------------------

        //  Assert column   checked_in_at   not null which confirms book checked in
        //
        $this->assertNotNull(Reservation::first()->checked_in_at);

        //  If first Book reservation record is checked then the timestamp for that record should
        //  Equal the book checked_in_at field of the current Book record as its just been created
        //
        $this->assertEquals(now(), Reservation::first()->checked_in_at);
    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 3 - Ensure if not checked out exception is thrown
    //
    //           This test is to ensure you cant check a Book in if it hasnt been checked out
    //

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function if_not_checked_out_exception_is_thrown()
    {
        //  This Exception is to ensure you cant check a Book in if it hasnt been checked out
        //
        $this->expectException(\Exception::class);

        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();

        //  A Book can have a checkin method called on it passing in a user
        //
        $book->checkin($user);

    }
    //----------------------------------------------------------------------------------------------


    //----------------------------------------------------------------------------------------------
    //  TEST 4 - Ensure a user can check out a book twice
    //

    //  This comment is impotant its live and Laravel is reading it
    //  and it is this comment that lets Laravel understand this is
    //  a test that has to be run and without it the test wont run
    //

    /** @test */
    public function a_user_can_check_out_a_book_twice()
    {
        //  Create a Book object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $book = factory(Book::class)->create();

        //  Create a User object using the factory() method and
        //  persist it to the database for the duration of this test
        //
        $user = factory(User::class)->create();


        //------------------------------------------------------------------------------------------
        //  CHECK OUT   -   CHECK IN   -   CHECK OUT
        //
        //  A Book can have a checkout method called on it passing in a user
        //
        $book->checkout($user);
        
        //  A Book can have a checkin method called on it passing in a user
        //
        $book->checkin($user);

        //  A Book can have a checkout method called on it passing in a user
        //
        $book->checkout($user);
        //------------------------------------------------------------------------------------------


        //  2 must be used as the Book has been checked out twice so there should be 2 reservations
        //
        $this->assertCount(2, Reservation::all());

        //  Here all()->last() instead of first() as the book has been checked out twice
        //
        $this->assertEquals($user->id, Reservation::all()->last()->user_id);
        $this->assertEquals($book->id, Reservation::all()->last()->book_id);
        $this->assertNull(Reservation::all()->last()->checked_in_at);
        $this->assertEquals(now(), Reservation::all()->last()->checked_out_at);

        //------------------------------------------------------------------------------------------
        //  Check Book back in to further test
        //
        $book->checkin($user);

        $this->assertCount(2, Reservation::all());
        $this->assertEquals($user->id, Reservation::all()->last()->user_id);
        $this->assertEquals($book->id, Reservation::all()->last()->book_id);

        //  Extra tests on Book checked in - asserNotNull - checked_in_at
        //
        $this->assertNotNull(Reservation::all()->last()->checked_in_at);
        $this->assertEquals(now(), Reservation::all()->last()->checked_in_at);
        //------------------------------------------------------------------------------------------

    }
    //----------------------------------------------------------------------------------------------

}
