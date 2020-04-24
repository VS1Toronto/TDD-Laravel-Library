<?php

namespace App;

use App\Author;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  MASS ASSIGNMENT
    //
    //  GUARDED EXAMPLE
    //
    //  *** WARNING ***     This turns off the Mass Assignment protection Laravel ships with
    //
    //  This allows you to mass assign data in BooksController store() method
    //  An empty array means nothing is guarded
    //
    protected $guarded = [];
    //--------------------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  RETURN PATH FOR THIS MODEL
    //
    public function path()
    {
        return '/books/' . $this->id;
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------


    public function setAuthorIdAttribute($author)
    {
        //----------------------------------------------------------------------------------------------------------------------------------------
        //  firstOrCreate()     is a Laravel helper which will find out if something is inside the database
        //                      and if it is it will retunr the object back and if not it will create it the
        //                      object and return it back
        //
        $this->attributes['author_id'] = (Author::firstOrCreate([
            'name' => $author,
        ]))->id;
        //----------------------------------------------------------------------------------------------------------------------------------------
    }

}
