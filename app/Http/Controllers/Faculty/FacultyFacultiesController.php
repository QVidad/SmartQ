<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;

class FacultyFacultiesController extends Controller
{
    public function index() {
        $faculties = User::where('role_id', '1')->get();
        // dd($students);
        return view('faculty.faculties', compact('faculties'));
    }

    // percentile computation
    // Percentile rank = Number of scores below the student's score + 0.5 x number of scores equal tot he student's score x 100 / total number of score
    public function downloadReport() {
        
    }

    public function createFaculty() {
        return view('faculty.create-faculty');
    }
}
