<?php

namespace App;

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
    //  This allows you to mass assign data in customer controller store() method
    //  An empty array means nothing is guarded
    //
    protected $guarded = [];
    //--------------------------------------------------------------------------------------------------------------------------------------------
}
