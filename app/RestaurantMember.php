<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RestaurantMember extends Model
{
 
    protected $table = 'restaurants';
 
 
    protected static function boot()
    {
        parent::boot();

         
        static::addGlobalScope('user_id', function (Builder $builder) {

            $loggedinid = Auth::user()->id;
            $loggedinemail = Auth::user()->email;
            $loggedintopicable_id = Auth::user()->topicable_id;
            $loggedintopicable_type = Auth::user()->topicable_type;

            if( $loggedintopicable_type == 'App\Restaurant' ){
                
                $builder->where('id', '=', $loggedintopicable_id);

            }else{

                $builder->where('id', '=', -1);
            }
            

        });
    } 
}
