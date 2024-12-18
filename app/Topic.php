<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $table = 'topics';
    protected $fillable = [
        'id','topic_id','topic_name','status'
    ];

    public function subtopics()
    {
        return $this->hasMany(SubTop::class, 'topic_id', 'topic_id');
    }


}
