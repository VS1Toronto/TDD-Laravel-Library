<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CheckinBookController extends Controller
{
    //  Constructor to allow Test 5 to work as 
    //
    public function __construct()
    {
        //-----------------------------------------------------------------------------------------------
        //  FEATURE TEST BookCheckoutTest.php TEST 5 uses this constructor
        //
        //  Test 5 needs this as the autheticated user is null initially
        //
        $this->middleware('auth');
        //-----------------------------------------------------------------------------------------------
    }


    public function store(Book $book)
    {
        try{
            //-----------------------------------------------------------------------------------------------
            //  FEATURE TEST BookCheckoutTest.php TEST 4 uses this method
            //
            //  Model Binding allows us to get the book here when the Feature test hits the end point
            //  with the book id passed in with it and it is assumed the user here is the authenticated user
            //
            $book->checkin(auth()->user());
            //-----------------------------------------------------------------------------------------------
        } catch (\Exception $e){

            //-----------------------------------------------------------------------------------------------
            //  In this instance there is no need to pass any data 
            //  but as a second parameter we do need to pass a 404
            //
            return response([], 404);
            //-----------------------------------------------------------------------------------------------
        }
    }
}
