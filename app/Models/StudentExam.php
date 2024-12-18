<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    protected $table = 'student_exams';

    protected $primaryKey = 'student_exam_id';

    protected $fillable = ['exam_id', 'student_id', 'start_time', 'end_time'];

    public function examination()
    {
        return $this->belongsTo(Examinations::class, 'exam_id', 'exam_id');
    }
}
