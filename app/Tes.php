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
}
