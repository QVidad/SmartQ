<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MajorQuestions;
use App\Topic;
use App\SubTop;
use App\Tes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Auth;
use App\Models\Examinations;

class Exam2Controller extends Controller
{
    function getquestionsmajorexam($topic){
        $arr=array();
        $q = MajorQuestions::where('subtopic_id',$topic)->where('status',1)->get()->sortBy('topic_id');
 
        if($q->count()==0){
            return 0;
        }

        foreach($q as $q){
            array_push($arr,$q->id);
        }
        return $arr;
    }
    function generate_q($topic,$n,$user,$examtype){
        $att = Tes::where('student_id',$user)->where('topic',$topic)->where('exam_type',$examtype)->get()->count();
        if($att+1==4){
            return $att+1;
        }
        $qst=$this->getquestionsmajorexam($topic);
        $x=json_encode($qst);
        if($x==""){
            return 2;
        }
        else{
            $nt = new Tes;       
            $nt->questions=$x;        
            $nt->attemp=$att+1;
            $nt->exam_type=$examtype;
            $nt->topic=$topic;
            $nt->student_id=$user;
            $nt->itemnum=$n;
            $nt->score=0;
            $nt->save();        
            return $nt->attemp;
        }
    }
    function getQ($id){
        $y=MajorQuestions::find($id);
        return $y;
    }

    
    //
    public function majorindex(Request $r){
        //id is user id, examid is exam id
        // dd($r->all());
        $user=Auth::user()->id;
        $exam_id = $r->examid;
        // dd($user);

        // $q = MajorQuestions::where('exam_id', $exam_id)
        //                     ->where('status', 1)->get('topic_id');
        // dd($q);
        $exam = Examinations::findOrFail($exam_id);
        $top=Topic::all();
        $topicIds = MajorQuestions::where('exam_id', $exam_id)
                    ->where('status', 1)->get('topic_id');;
        $time=1;
        $subtopic=SubTop::whereIn('topic_id', $topicIds)->get();
        $subtopicids=SubTop::whereIn('topic_id', $topicIds)->get('subtopic_id');
        $att1 = Tes::where('student_id', $user)
        ->where('exam_type', $r->examid)
        // ->where('exam_type', 1)
        // ->where('exam_id', $r->examid)
        ->latest()
        ->first();
        if($att1)
            $attemp=$att1->attemp+1;            
        else    
           $attemp=1;
        foreach($subtopicids as $x){
            $q = MajorQuestions::where('subtopic_id', $x["subtopic_id"])
                                ->where('exam_id', $exam_id)
                                ->where('status', 1)->get()
                                ->sortBy('topic_id');
            if($q->count()==0){
                continue;
            }
            $attemp1=$this->generate_q($x["subtopic_id"],$q->count(),$user,$exam_id);          
            if($attemp1!=-1){
                $attemp=$attemp;
            }
        }
        if($attemp>1){
            return view('max_attempt');
        }
        $ques = collect();
        $st = SubTop::whereIn('topic_id',$topicIds)->get();

        foreach($st as $st){
            $tps=Topic::where('topic_id',$st->topic_id)->first()->topic_name;
            $responses=Tes::where('student_id',$user)->where('topic',$st->subtopic_id)->where('exam_type',$exam_id)->latest()->first();  
                if($responses=="")
                    continue;
                $questions=json_decode($responses->questions);
                $w=1;
                foreach($questions as $x){
                    $q=$this->getQ($x);       
                    $ques->push([
                        'no' => $w,
                        'topic'=>$tps,
                        'subtopic'=>$st->name,
                        'desc' => $q->qdesc,
                        'opt1'=>$q->opt1,
                        'opt2'=>$q->opt2,
                        'opt3'=>$q->opt3,
                        'opt4'=>$q->opt4,
                        'sr'=>$responses->id,
                    ]);
                    $w++;
                }
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Define items per page as 1
        $perPage = 1;
        // Slice the collection for the current page
        $currentPageItems = $ques->slice(($currentPage - 1) * $perPage, $perPage)->values();
        // Create paginator with the sliced items
        $paginatedQuestions = new LengthAwarePaginator(
            $currentPageItems, // Items for the current page
            $ques->count(), // Total items in the collection
            $perPage, // Items per page
            $currentPage, // Current page
            ['path' => request()->url()] // Maintain the base URL
        );
        // Determine if the current page is the last page
        $isLastPage = $currentPage == $paginatedQuestions->lastPage();
        $time = $exam->duration;
        // dd($time);
        
        return view('majorexam', ['questions' => $ques, 'examtype'=>$exam_id,'isLastPage' => $isLastPage,'time'=>$time,'attemp'=>$attemp,'user'=>$user]);
     }
    public function submitquestions(Request $request)
    {
        return $request->all();
    }


public function submitFinalAnswers(Request $request)
{
   return $request->all();
}
public function savePageAnswers(Request $request)
{
    $allAnswersJson = $request->input('allAnswers');
    $allAnswers = json_decode($allAnswersJson, true); // Decode JSON to associative array

    // Fetch responses based on conditions
    $responses = Tes::where('student_id', $request->user)
        ->where('attemp', $request->attemp)
        ->where('exam_type', $request->examtype)
        ->latest()
        ->get();

    $responseScores = []; // Array to hold scores and answer correctness for each response
    $tps = "";
    $totalQuestions = 0;
    $totalScore = 0; // Variable to track total score across all responses

    foreach ($responses as $r) {
        $qb = json_decode($r->questions); // Questions basis
        $co = 0;
        $tname = "";
        $score = 0;
        $x = Tes::find($r->id);
        $answers = [];
        $answerResults = []; // Array to store answer correctness details

        $st = SubTop::where('subtopic_id', $r->topic)->first();
        if ($st) {
            $tname = $st->name;
        }

        if ($tps == null) {
            $tps = Topic::where('topic_id', $st->topic_id)->first()->topic_name;
        }

        foreach ($allAnswers[$r->id] as $ans) {
            $currentQuestion = $qb[$co] ?? [
                'details' => 'No details available',
                'correct_answer' => 0,
                'feedback' => 'No feedback available',
            ];

            // Get the question and correct answer
            $isCorrect = $this->check_question($currentQuestion, $ans) ?? 0;

            // Calculate score based on correctness
            $score += $isCorrect;
            $answers[] = $ans; // Collect the answer

            // Add question answer correctness to the array
            $answerResults[] = [
                'question_no' => $co + 1,
                'question_details' => $this->getquestion($qb[$co]),
                'selected_answer' => $this->getans($qb[$co], $ans),
                'correct_answer' => $this->getcorans($qb[$co]),
                'feedback' => $this->getquestionfeed($qb[$co]),
                'topic' => $this->gettopic($qb[$co]),
                'is_correct' => $isCorrect
            ];
            $topicz=$this->gettopic($qb[$co]);
            $co++;
            $totalQuestions++;
        }

        // Save answers and score to the database
        $x->answers = json_encode($answers);
        $x->score = $score;
        $x->save();

        // Add this response's score to the total score
        $totalScore += $score;

        // Add this response's score and answer details to the array for display
        $responseScores[] = [
            'response_id' => $tname,
            'total_score' => $score,
            'total_point' => $co,
            'topic' =>  $topicz,
            'answers' => $answerResults
        ];
    }
    // Return the scores and answers with correctness to a view
    return view('majorsresults2', compact('responseScores', 'tps', 'totalScore', 'totalQuestions'));
}



public function check_question($q,$a){
    $q=MajorQuestions::find($q);
    if($q->ans==$a){
        return 1;
    }        
    return 0;
    //return $this->generate_exam(1);
}


public function getcorans($q){
    $q=MajorQuestions::find($q);
    switch($q->ans){
        case 1:return $q->opt1;break;
        case 2:return $q->opt2;break;
        case 3:return $q->opt3;break;
        case 4:return $q->opt4;break;
        case 5:return $q->opt5;break;
    }      
    //return $this->generate_exam(1);
}
public function getans($q,$ans){
    $q=MajorQuestions::find($q);
    switch($ans){
        case 0:return "Did not Answer";break;
        case 1:return $q->opt1;break;
        case 2:return $q->opt2;break;
        case 3:return $q->opt3;break;
        case 4:return $q->opt4;break;
        case 5:return $q->opt5;break;
    }      
    //return $this->generate_exam(1);
}
public function getquestion($q){
    $q=MajorQuestions::find($q);
    return $q->qdesc;
    //return $this->generate_exam(1);
}
public function gettopic($q){
    $q=MajorQuestions::find($q);
    $tps=Topic::where('topic_id',$q->topic_id)->first()->topic_name;
    return $tps;
    //return $this->generate_exam(1);
}
public function getquestionfeed($q){
    $q=MajorQuestions::find($q);
    return $q->reff;
    //return $this->generate_exam(1);
}
}
