<?php

namespace App;

use App\Author;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  CHECKOUT FUNCTION
    //
    public function checkout($user)
    {
        //----------------------------------------------------------------------------------------------------------------------------------------
        //  Create Reservation
        //
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(),
        ]);
        //----------------------------------------------------------------------------------------------------------------------------------------        
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  CHECKIN FUNCTION
    //
    public function checkin($user)
    {
        //  Give us a reservation where the user_id matches the $user passed in user_id
        //
        $reservation = $this->reservations()->where('user_id', $user->id)

            //  Check Book already checked out
            //
            //  whereNotNull   or in other words   where the book has already been checked out
            //  this will be the case if the   checked_out_at   column is not null i.e. it contains
            //  a timestamp
            //
            ->whereNotNull('checked_out_at')

            //  Check Book not already checked in
            //
            //  whereNull   or in other words   where the book has not already been checked in
            //  this will be the case if the   checked_in  column is null i.e. it does not contain
            //  a timestamp
            //
            ->whereNull('checked_in_at')

            //  Return first reservations record in reservations table in database
            //
            ->first();

            //  For UNIT TEST 3   if_not_checked_out_exception_is_thrown 
            //
            if (is_null($reservation)) {
                throw new \Exception();
            }

            $reservation->update([
                'checked_in_at' => now(),
            ]);
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


    //--------------------------------------------------------------------------------------------------------------------------------------------
    //  RESERVATIONS FUNCTION
    //
    //  Part of creating a relationship with Reservation
    //
    public function reservations()
    {
        //----------------------------------------------------------------------------------------------------------------------------------------
        //  This model Book hasMany Reservations
        //
        return $this->hasMany(Reservation::class);
        //----------------------------------------------------------------------------------------------------------------------------------------        
    }
    //--------------------------------------------------------------------------------------------------------------------------------------------

}
