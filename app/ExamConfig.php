<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamConfig extends Model
{
    //
    protected $table = 'exam_config';
    protected $fillable = [
        'id','exam_desc','type','item_num','status','time'
    ];
}
