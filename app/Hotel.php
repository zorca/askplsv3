<?php

namespace App;

use Auth;
use App\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Hotel extends Model
{
    public function topiccategories()
    {
  

    	return $this->morphMany('App\TopicCategory', 'topicable');

    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user_id', function (Builder $builder) {

            $loggedinid = Auth::user()->id;
            $loggedinemail = Auth::user()->email;

            $loggedinrole = Auth::user()->role;
            
            if( $loggedinrole == 'agent' ){

            	$loggedincityid = Auth::user()->city_id;

            	$loggedincityname =  City::find($loggedincityid)->name;
                
                $builder->where('city', '=', $loggedincityname);

            }
            

        });
    }
}
