<?php

namespace App\Models;

use App\Tes;
use Illuminate\Database\Eloquent\Model;

class Examinations extends Model
{
    protected $table = "examinations";
    protected $primaryKey = 'exam_id';

    public function responses()
    {
        return $this->hasMany(Tes::class, 'exam_type', 'exam_id');
    }

    public function studentExams()
    {
        return $this->hasMany(StudentExam::class, 'exam_id', 'exam_id');
    }
}
