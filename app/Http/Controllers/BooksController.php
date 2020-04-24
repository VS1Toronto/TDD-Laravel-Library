<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function store()
    {
        //----------------------------------------------------------------------------------------------
        //  Using Validation Method
        //
        $data = $this->validateRequest();

        //  The instance returned back from the create method is saved to variable
        //  $book here so that it can be used to redirect in the final step of this method
        //
        $book = Book::create($data);

        //  Using the path() method in the Book Model for redirect
        //
        return redirect($book->path());
        //----------------------------------------------------------------------------------------------
    }


    public function update(Book $book)
    {
        //----------------------------------------------------------------------------------------------
        //  Using Validation Method
        //
        $data = $this->validateRequest();

        $book->update($data);

        //  Using the path() method in the Book Model for redirect
        //
        return redirect($book->path());
        //----------------------------------------------------------------------------------------------                
    }


    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }


    protected function validateRequest()
    {
        //----------------------------------------------------------------------------------------------
        //  This is being explicit about the fields that are being passed in
        //  and so we can safely turn off the Mass Assignment protection Laravel
        //  ships with by adding   protected $guarded = [];   in the model
        //
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required',
        ]);
        //----------------------------------------------------------------------------------------------
    }
}
