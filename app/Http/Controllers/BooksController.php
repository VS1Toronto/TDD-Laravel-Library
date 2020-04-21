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

        Book::create($data);
        //----------------------------------------------------------------------------------------------
    }


    public function update(Book $book)
    {
        //----------------------------------------------------------------------------------------------
        //  Using Validation Method
        //
        $data = $this->validateRequest();

        $book->update($data);
        //----------------------------------------------------------------------------------------------                
    }


    /**
     * @return mixed
     */
    protected function validateRequest()
    {
        //----------------------------------------------------------------------------------------------
        //  This is being explicit about the fields that are being passed in
        //  and so we can safely turn off the Mass Assignment protection Laravel
        //  ships with by adding   protected $guarded = [];   in the model
        //
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
        //----------------------------------------------------------------------------------------------
    }
}
