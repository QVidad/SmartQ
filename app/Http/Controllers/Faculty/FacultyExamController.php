<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Examinations;
use App\Models\MajorQuestions;
use App\Topic;
use App\Subtop;

use Carbon\Carbon;
use Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class FacultyExamController extends Controller
{
    public function index() {

        return view('faculty.exam', );
    }

    public function createExam() {
        $topic = Topic::all();
        $subtopic = Subtop::all();

        return view('faculty.create', compact('topic', 'subtopic'));
    }

    public function addExam(Request $r) {
        // dd($r->all());

        $exam = new Examinations();
        if($r->examType == "1") {
            $exam->exam_name = $r->name;
            $exam->description = $r->description;
            $exam->created_by = Auth::user()->id;
            $exam->start_date = $r->startDate;
            $exam->end_date = $r->startDate;
            $exam->exam_type = $r->examType;
            $exam->duration = $r->duration;

            $exam->save();

            $questions = $r->questions;
            foreach($questions as $question) {
                $q = new MajorQuestions();

                $q->qdesc = $question['question']; 
                $q->opt1 = $question['option1']; 
                $q->opt2 = $question['option2']; 
                $q->opt3 = $question['option3']; 
                $q->opt4 = $question['option4']; 
                $q->ans = $question['correctAnswer']; 
                $q->reff = $question['reference']; 
                $q->topic_id = $question['topic_id'];
                $q->subtopic_id = $question['subtopic_id'];
                $q->exam_id = $exam->exam_id;

                $q->save();
            }
        } else {
            $exam->exam_name = $r->name;
            $exam->description = $r->description;
            $exam->created_by = Auth::user()->id;
            $exam->item_num = $r->item_num;
            $exam->start_date = $r->startDate;
            $exam->end_date = $r->startDate;
            $exam->exam_type = $r->examType;
            $exam->duration = $r->duration;

            $exam->save();
        }
    }

    public function fetchExams() {
        return Examinations::all();
    }

    public function configureExam($id) {
        $topics = Topic::all();
        $subtopics = Subtop::all();

        $exam = Examinations::where('exam_id', $id)->first();
        $questions = MajorQuestions::where('exam_id', $id)->get();

        return view('faculty.configure', compact('exam', 'questions', 'topics', 'subtopics'));
    }

    public function updateExam(Request $r) {
        // dd($r->all());
        // dd($r->questions);
        $exam = Examinations::where('exam_id', $r->id)->first();

        if($exam->exam_type == 1) {
            $exam->exam_name = $r->name;
            $exam->description = $r->description;
            $exam->created_by = Auth::user()->id;
            $exam->start_date = $r->startDate;
            $exam->end_date = $r->startDate;
            $exam->duration = $r->duration;

            $exam->save();

            $questions = $r->questions;
            foreach($questions as $question) {
                $q = MajorQuestions::where('id', $question['id'])->first();
                if($q) {
                    $q->qdesc = $question['qdesc']; 
                    $q->opt1 = $question['opt1']; 
                    $q->opt2 = $question['opt2']; 
                    $q->opt3 = $question['opt3']; 
                    $q->opt4 = $question['opt4']; 
                    $q->ans = $question['ans']; 
                    $q->reff = $question['reff'];
                    $q->topic_id = $question['topic_id'];
                    $q->subtopic_id = $question['subtopic_id']; 

                    $q->save();
                } else {
                    $q = new MajorQuestions();

                    $q->qdesc = $question['qdesc']; 
                    $q->opt1 = $question['opt1']; 
                    $q->opt2 = $question['opt2']; 
                    $q->opt3 = $question['opt3']; 
                    $q->opt4 = $question['opt4']; 
                    $q->ans = $question['ans']; 
                    $q->reff = $question['reff']; 
                    $q->topic_id = $question['topic_id'];
                    $q->subtopic_id = $question['subtopic_id'];
                    $q->exam_id = $exam->exam_id;

                    $q->save();
                }
                
            }
        } else {
            $exam->exam_name = $r->name;
            $exam->description = $r->description;
            $exam->created_by = Auth::user()->id;
            $exam->item_num = $r->item_num;
            $exam->start_date = $r->startDate;
            $exam->end_date = $r->startDate;
            $exam->duration = $r->duration;

            $exam->save();
        }
    }

    public function examReport($id) {
        $exam = Examinations::findOrFail($id);

        return view('faculty.exam-report');
    }

    public function downloadReport($id) {
        $exam = Examinations::findOrfail($id);
        // dd($exam);
        // Load the view and pass the exam data
        $pdf = Pdf::loadView('reports.exam_report', compact('exam'));

        // Return the PDF download response
        return $pdf->download("Exam_Details_{$exam->exam_name}.pdf");
    }
}
