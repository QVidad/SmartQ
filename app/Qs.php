<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qs extends Model
{
    protected $table = 'questions';
    protected $fillable = ['qdesc', 'opt1', 'opt2', 'opt3', 'opt4', 'opt5', 'ans', 'created_by', 'topic_id', 'status', 'reff'];
    //

    public function subtopic()
    {
        return $this->belongsTo(SubTop::class, 'topic_id', 'subtopic_id');
    }

}
