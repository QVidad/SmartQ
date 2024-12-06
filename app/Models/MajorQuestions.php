<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorQuestions extends Model
{
    // protected $table = 'questions';
    protected $fillable = ['qdesc', 'opt1', 'opt2', 'opt3', 'opt4','ans', 'created_by', 'topic_id', 'status', 'reff'];

    protected $table = 'major_questions';
    public $timestamps = false;
}
