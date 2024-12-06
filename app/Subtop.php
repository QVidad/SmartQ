<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubTop extends Model
{
    //
    protected $table = 'subtopic';
    protected $fillable = [
        'subtopic_id','topic_id','name','status'
    ];
}
