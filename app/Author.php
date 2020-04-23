<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  MASS ASSIGNMENT
    //
    //  GUARDED EXAMPLE
    //
    //  *** WARNING ***     This turns off the Mass Assignment protection Laravel ships with
    //
    //  This allows you to mass assign data in AuthorsController store() method
    //  An empty array means nothing is guarded
    //
    protected $guarded = [];
    //--------------------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  REQUIRED FOR dob to have valid date / time format for database
    //
    protected $dates = ['dob'];
    //--------------------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  This is mutating the 'dob' attribute to the correct format for the database
    //
    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = Carbon::parse($dob);
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------

}