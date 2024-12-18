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

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'topic_id');
    }

    public function questions()
    {
        return $this->hasMany(Qs::class, 'topic_id', 'subtopic_id');
    }

    public function responses()
    {
        return $this->hasMany(Tes::class, 'topic', 'subtopic_id');
    }

}
