<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model; 

class Company extends Model
{

    public function topiccategories()
    {
  

        return $this->morphMany('App\TopicCategory', 'topicable');

    }
    
}
