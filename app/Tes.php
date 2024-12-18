<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tes extends Model
{
    //
    protected $table = 'student_responses';
    protected $fillable = [
        'id','exam_type','topic','student_id','questions','answers','score','itemnum','attemp'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic', 'topic_id');
    }

    public function examination()
    {
        return $this->belongsTo(Examinations::class, 'exam_type', 'exam_id');
    }

    public function subtopic()
    {
        return $this->belongsTo(SubTop::class, 'topic', 'subtopic_id');
    }
}
