<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class CheckoutBookController extends Controller
{
    //  Constructor to allow Test 2 to work as 
    //
    public function __construct()
    {
        //-----------------------------------------------------------------------------------------------
        //  FEATURE TEST BookCheckoutTest.php TEST 2 uses this constructor
        //
        //  Test 2 needs this as the autheticated user is null initially
        //
        $this->middleware('auth');
        //-----------------------------------------------------------------------------------------------
    }


    public function store(Book $book)
    {
        //-----------------------------------------------------------------------------------------------
        //  FEATURE TEST BookCheckoutTest.php TEST 1 uses this method
        //
        //  Model Binding allows us to get the book here when the Feature test hits the end point
        //  with the book id passed in with it and it is assumed the user here is the authenticated user
        //
        $book->checkout(auth()->user());
        //-----------------------------------------------------------------------------------------------
    }
}
