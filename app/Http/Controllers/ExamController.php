<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionImport;
use App\Qs;
use App\Tes;
use App\ExamConfig;
use App\Topic;
use App\SubTop;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Auth;
use App\Models\Examinations;
use Carbon\Carbon;

class ExamController extends Controller
{
    //
    public function index2() {
        return view('import');
    }
    
    public function import(Request $r) 
    {
        Excel::import(new QuestionImport, $r->file('file'));
        return redirect('/uploadfile')->with('success', 'Upload Success');
        return back();
    }


    public function index(){
        $q = Qs::all();
        return $q->count();
    }




    function gen_array($n,$l,$m,$t)
    {
        $ques = array();
        for($i=0;$i<$n;){
            $x=$this-> check_ques($l,$m,$t);
            $ques[$i]=$x;
            if($i>0){
                for($j=0;$j<$i;$j++){                
                    if($x==$ques[$j]){
                        $x=$this-> check_ques($l,$m,$t);
                        $j=0;
                    }
                }
            }
            $i++;
        }
        return $ques;
    }
    function comp($x,$y,$n){
        for($i=0;$i<$n;$i++){
            for($j=0;$j<$n;$j++){
                if($x[$i]==$y[$j])
                    return 1;
            }
        }
        return 0;
    }

    function getQ($id){
        $y=Qs::find($id);
        return $y;
    }

    
    function check_ques($l,$m,$t)
    {
        $c=0;
        while($c==0){
            $x=rand($l,$m);
            $q=Qs::where('topic_id',$t)->where('id',$x)->where('status',1)->first();
            if($q){
                $c=$x;
            }
        }
        return $c;
    }

    public function check_question($q,$a){
        $q=Qs::find($q);
        if($q->ans==$a){
            return 1;
        }        
        return 0;
        //return $this->generate_exam(1);
    }


    public function update_score($ans,$id){
        $x=Tes::find($id);
        $x->answers=serialize($ans);
        $qs=json_decode($x->questions);
        $s=0;
        $f=0;
        foreach($qs as $qs){
            $s=$s+$this->check_question($qs,$ans[$f+1]);
            $f++;
        }
        $x->score=$s;
        $x->save();
        return $s;
        
        //return $this->generate_exam(1);
    }

    public function getQans($q){
        $q=Qs::find($q);
        switch($q->ans){
            case 1:return $q->opt1;break;
            case 2:return $q->opt2;break;
            case 3:return $q->opt3;break;
            case 4:return $q->opt4;break;
            case 5:return $q->opt5;break;
        }      
        //return $this->generate_exam(1);
    }
    public function getQans1($q,$a){
        $q=Qs::find($q);
        switch($a){
            case 1:return $q->opt1;break;
            case 2:return $q->opt2;break;
            case 3:return $q->opt3;break;
            case 4:return $q->opt4;break;
            case 5:return $q->opt5;break;
        }      
        //return $this->generate_exam(1);
    }

    public function getSubTop($q){
        $q=SubTop::where('subtopic_id',$q)->first();        
        return $q->name;
        //return $this->generate_exam(1);
    }

    public function getTop($q){
        $q=SubTop::where('subtopic_id',$q)->first(); 
        $z=Topic::where('topic_id',$q->topic_id)->first();            
        return $z->topic_name;
        //return $this->generate_exam(1);
    }

    public function getTop1($q){         
        return $q;
        //return $this->generate_exam(1);
    }



    public function store(Request $r){       
        // Trial Exam Rsult
        if($r->extype==2){          
            $conf = ExamConfig::where('status', 1)->where('type', 2)->first();
            $data = unserialize($r->input('ids'));
            $x = Tes::whereIn('id', $data)->get();        
            $score = collect();
            $ques = collect();
            $maintopc = "";
            $total = 0;
            $totalQuestions = 0;
            foreach ($x as $x) {
                $ans = $r->radio[$x->topic];
                $s = $this->update_score($ans, $x->id);
                $total += $s;
        
                if ($maintopc == "") {
                    $maintopc = $this->getTop($x->topic);
                }
        
                $score->push([
                    'name' => $this->getSubTop($x->topic),
                    'score' => $s,
                ]);
        
                $z = json_decode($x->questions);
                $y = unserialize($x->answers);
                $w = 1;
                foreach ($z as $z) {
                    $q = $this->getQ($z);
                    $anz = $y[$w] ?? 0;
                    $ques->push([
                        'no' => $w,
                        'desc' => $q->qdesc,
                        'opt1' => $q->opt1,
                        'opt2' => $q->opt2,
                        'opt3' => $q->opt3,
                        'opt4' => $q->opt4,
                        'opt5' => $q->opt5,
                        'ans' => $q->ans,
                        'reff' => $q->reff,
                        'stans' => $anz,
                        'tops' => $this->getSubTop($x->topic),
                    ]);
                    $w++;
                    $totalQuestions++;
                }
            }
            $i = $conf->item_num;        
            // Debugging outputs
            \Log::info('Questions:', ['ques' => $ques]);
            \Log::info('Scores:', ['score' => $score]);        
            return view('result', compact('ques', 'score', 'maintopc', 'total', 'i', 'totalQuestions'));
        }
        // Actual Exam Result
        else{
            $conf = ExamConfig::where('status',1)->where('type',1)->first();
            $data = unserialize($r->input('ids'));    
            $x=Tes::whereIn('id',$data)->get();  
            $score = array();
            $ques = collect();
            $maintopc = array();
            $total = 0;
            $i = 0;
            $totalQuestions = 0;
            foreach($x as $x){                
                $ans=$r->radio[$x->topic];    
                $s=$this->update_score($ans,$x->id);
                $total=$total+$s;                
                $z=json_decode($x->questions);
                $y=unserialize($x->answers);      
                $score[$i]=$s;                    
                $maintopc[$i]=Topic::where('topic_id',$x->topic)->first()->topic_name;    
                $w=1;
                foreach($z as $z){
                    $q=$this->getQ($z);
                    $anz = $y[$w] ?? 0;
                        $ques->push([
                            'no' => $w,
                            'desc' => $q->qdesc,
                            'opt1'=>$q->opt1,
                            'opt2'=>$q->opt2,
                            'opt3'=>$q->opt3,
                            'opt4'=>$q->opt4,
                            'opt5'=>$q->opt5,
                            'ans' =>$q->ans,
                            'reff' => $q->reff,
                            'stans' =>$anz,
                            'tops'=>$maintopc[$i],
                        ]);
                    $w++;
                    $totalQuestions++;
                }
                $i++;
            }
            $j=$i;
            $i=$conf->item_num;
            return view('result2',compact('ques','score','maintopc','total','i','j','totalQuestions'));
        }
      
    }
    public function indexz(){
        // return $this->generate_mockexam(2,1);
        $now = \Carbon\Carbon::now()->format('Y-m-d');
        $user = Auth::user()->id;
        $top = Examinations::where('start_date', '<=', $now)
                            ->where('end_date', '>=', $now)->get();
        // dd($top);
        return view('/exam', compact('user','top'));
     }

     public function indexTrial() {
        $user = Auth::user()->id;
        $top = Topic::all();
        return view('/trial',compact('user', 'top'));
     }

     public function indexResults(){
        //alaek biit amin nga major exam
        $exams = Examinations::where('exam_type', 1)->get();
        //sumaruno kt alaen dagijay student responses kadejay nga major exam
        $results = []; // total items, total score, percentage
        foreach($exams as $examKey => $exam) {
            $responses = Tes::where('exam_type', $exam->exam_id)->where('student_id', Auth::user()->id)->get();
            if(!$responses->isEmpty()) {
                $results[$examKey]['total_item'] = $results[$examKey]['total_item'] ?? 0;
                $results[$examKey]['total_score'] = $results[$examKey]['total_score'] ?? 0;
                $results[$examKey]['percentage'] = $results[$examKey]['percentage'] ?? 0;
                $results[$examKey]['exam_id'] = $exam->exam_id;
                $results[$examKey]['exam_name'] = $exam->exam_name;
                $results[$examKey]['end_date'] = $exam->end_date;
                $results[$examKey]['start_date'] = $exam->start_date;

                foreach($responses as $key => $response) {
                    $item = count(json_decode($response->questions));

                    $results[$examKey]['total_item'] += $item;
                    $results[$examKey]['total_score'] += $response->score;
                }
                $results[$examKey]['percentage'] = round(($results[$examKey]['total_score'] / $results[$examKey]['total_item']) * 100, 2);;
            }
        }
        // dd($results);
        
        $user = Auth::user()->id;
        return view('/results', compact('user', 'results'));
    }

    public function index3(Request $r){
        return $this->generate_exam($r->id);
    }

    public function index4(Request $r){
        // dd($r->all());
        return $this->generate_mockexam($r->topic, $r->id);
    }

    public function generate_exam($user){
        $y=Qs::all()->count();      
        $conf = ExamConfig::where('status', 1)->where('type',1)->first();
        $time=$conf->time;
        $n=$conf->item_num;
        $tpc = Topic::all();
        $totalQuestions = 0;
        $num =1;
        foreach($tpc as $tpc){
            $st = SubTop::where('topic_id',$tpc->topic_id)->where('status',1)->get('subtopic_id')->toArray();
            $attemp=0;
            $min=Qs::whereIn('topic_id',$st)->where('status',1)->get()->min('id');        
            $max=Qs::whereIn('topic_id',$st)->where('status',1)->get()->max('id');     
            $attemp=$this->generate_q2($min,$max,$st,$n,$user,1,$tpc->topic_id);
            $attemp;
            
            if($attemp>1){
                return view('max_attempt'); //Fully Examed
            }
        }            
        $ques = array();  
        $tl = array();
        $ids = array();
        $z=1;
        $tpc = Topic::all();
        $sts = array();
        $k=0;
        foreach($tpc as $tpc){        
                $i=0;
                $x=Tes::where('student_id',$user)->where('topic',$tpc->topic_id)->where('exam_type',1)->where('attemp',$attemp)->latest()->first();      
                $ids[$z-1]=$x->id;
                $x=json_decode($x->questions);
                foreach($x as $x){
                    $y=$this->getQ($x);           
                    $ques[$z][$i]['id']=$y->id;
                    $ques[$z][$i]['qn']=$i+1;
                    $ques[$z][$i]['q']=$y->qdesc;
                    $ques[$z][$i]['c1']=$y->opt1;
                    $ques[$z][$i]['c2']=$y->opt2;
                    $ques[$z][$i]['c3']=$y->opt3;
                    $ques[$z][$i]['c4']=$y->opt4;
                    $ques[$z][$i]['c5']=$y->opt5;
                    $i++;
                    $totalQuestions++;
                }
                $z++;
         
        }
        $st = Topic::where('status',1)->get('topic_id')->toArray();
        $c=$n;
        $k=$i=$j=0;
        $tops=$z;
        $a = array();
        $ids=$ids;
        $tpc = Topic::where('status',1)->get('topic_name')->toArray();
        $ext=1;
        return view('actualexam',compact('ques','c','i','j','a','user','ids','tpc','tl','k','sts','time','tops','st','ext','attemp','totalQuestions','num'));
    }

    public function generate_mockexam($topic, $user) {
        $y = Qs::all()->count();
        $examtype=0;
        $conf = ExamConfig::where('status', 1)->where('type', 2)->first();
        $time = $conf->time;
        $top = $topic;
        $user = $user;
        $n = $conf->item_num;
        $st = SubTop::where('topic_id', $top)->get();
        $tpcx = SubTop::where('topic_id', $top)->get('subtopic_id')->toArray();
        $attemp = 0;
        $totalQuestions = 0;
        $num =1;
        $att1 = Tes::where('student_id', $user)
        ->where('exam_type',  $examtype)
        ->latest()
        ->first();
        if($att1)
            $attemp=$att1->attemp+1;            
        else    
           $attemp=1;
        foreach ($st as $st) {
            $q = Qs::where('topic_id',$st->subtopic_id)->where('status',1)->get()->sortBy('topic_id');
            if($q->count()==0){
                continue;
            }
            $min = Qs::where('topic_id', $st->subtopic_id)->where('status', 1)->get()->min('id');
            $max = Qs::where('topic_id', $st->subtopic_id)->where('status', 1)->get()->max('id');
            $result = $this->generate_q($min, $max, $st->subtopic_id, $n, $user,  $examtype);
            $attemp1 = $result['attempt'];
            if($attemp1!=-1){
                $attemp=$attemp;
            }
        }
     
        if ($attemp > 3) {
            return view('max_attempt'); //Fully Trialled
        }
    
        $ques = collect();
        $st = SubTop::where('topic_id', $top)->get();
        $z = 1;
        $ids = array();
        foreach ($st as $st) {
            $i = 0;
            $tps=Topic::where('topic_id',$st->topic_id)->first()->topic_name;
            $responses=Tes::where('student_id',$user)->where('topic',$st->subtopic_id)->where('exam_type',$examtype)->latest()->first();  
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
        $time=1;
 
        return view('trialexamversion2', ['questions' => $ques, 'examtype'=>$examtype,'isLastPage' => $isLastPage,'time'=>$time,'attemp'=>$attemp,'user'=>$user]);
    }
    

    function generate_q2($min,$max,$topic,$n,$user,$xts,$tops){
        $temp=0;
        while($temp==0){
            $tt=Tes::where('topic',$tops)->latest()->take(5)->get();
            if($tt->count()==0){
                $x=$this->gen_array2($n,$min,$max,$topic);
                $temp=1;
                continue;
            }
            foreach($tt as $tt){
                $y=json_decode($tt->tdesc);
                $x=$this->gen_array2($n,$min,$max,$topic);
                $z=$this->comp($x,$y,$n);
                if($z==0){
                    $temp=1;
                    break;
                }
                
            }
        }    
        $att = Tes::where('student_id',$user)->where('topic',$tops)->where('exam_type',$xts)->get()->count();
        if($att+1==4){
            return $att+1;
        }
        $nt = new Tes;       
        $nt->questions=json_encode($x);        
        $nt->attemp=$att+1;
        $nt->exam_type=$xts;
        $nt->topic=$tops;
        $nt->student_id=$user;
        $nt->itemnum=$n;
        $nt->score=0;
        $nt->save();
        return $nt->attemp;
    }

    function check_ques2($l,$m,$t){
        $c=0;
        while($c==0){
            $x=rand($l,$m);
            $q=Qs::whereIn('topic_id',$t)->where('id',$x)->where('status',1)->first();
            if($q){
                $c=$x;
            }
        }
        return $c;
    }
    function gen_array2($n,$l,$m,$t)
    {
        $ques = array();
        for($i=0;$i<$n;){
           $x=$this-> check_ques2($l,$m,$t);
            $ques[$i]=$x;
            if($i>0){
                for($j=0;$j<$i;$j++){                
                    if($x==$ques[$j]){
                        $x=$this-> check_ques($l,$m,$t);
                        $j=0;
                    }
                }
            }
            $i++;
        }
        return $ques;
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
                    'is_correct' => $isCorrect
                ];
    
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
                'answers' => $answerResults
            ];
        }
    
        // Return the scores and answers with correctness to a view
        return view('majorsresults', compact('responseScores', 'tps', 'totalScore', 'totalQuestions'));
    }
    


    
    public function getcorans($q){
        $q=Qs::find($q);
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
        $q=Qs::find($q);
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
        $q=Qs::find($q);
        return $q->qdesc;
        //return $this->generate_exam(1);
    }
    public function getquestionfeed($q){
        $q=Qs::find($q);
        return $q->reff;
        //return $this->generate_exam(1);
    }
    function generate_q($min, $max, $topic, $n, $user, $xts) {
        $temp = 0;

        while ($temp == 0) {
            $tt = Tes::where('topic', $topic)->latest()->take(5)->get();
    
            if ($tt->count() == 0) {
                $x = $this->gen_array($n, $min, $max, $topic);
                $temp = 1;
                continue;
            }
    
            foreach ($tt as $temp) {
                $y = json_decode($temp->questions);
                $x = $this->gen_array($n, $min, $max, $topic);
                $z = $this->comp($x, $y, $n);
                if ($z == 0) {
                    $temp = 1;
                    break;
                }
            }
        }
    
        $att = Tes::where('student_id', $user)->where('topic', $topic)->where('exam_type', $xts)->get()->count();
        if ($att + 1 == 4) {
            return $att + 1;
        }
    
        $nt = new Tes;
        $nt->questions = json_encode($x);
        $nt->attemp = $att + 1;
        $nt->exam_type = $xts;
        $nt->topic = $topic;
        $nt->student_id = $user;
        $nt->itemnum = $n;
        $nt->score = 0;
        $nt->save();
        return ['attempt' => $nt->attemp];
    }    
}