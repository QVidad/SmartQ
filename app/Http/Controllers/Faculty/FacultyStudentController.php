<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class FacultyStudentController extends Controller
{
    public function index() {
        $students = User::where('role_id', '2')->get();
        // dd($students);
        return view('faculty.students', compact('students'));
    }

    // percentile computation
    // Percentile rank = Number of scores below the student's score + 0.5 x number of scores equal tot he student's score x 100 / total number of score
    public function downloadReport() {
        
    }
}
