<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    public function store()
    {
        //----------------------------------------------------------------------------------------------
        //  Inline Validation
        //
        Author::create($this->validateRequest());
        //----------------------------------------------------------------------------------------------
    }

    protected function validateRequest()
    {
        //----------------------------------------------------------------------------------------------
        //  This is being explicit about the fields that are being passed in
        //  and so we can safely turn off the Mass Assignment protection Laravel
        //  ships with by adding   protected $guarded = [];   in the model
        //
        return request()->validate([
            'name' => 'required',
            'dob' => 'required',
        ]);
        //----------------------------------------------------------------------------------------------
    }
}
