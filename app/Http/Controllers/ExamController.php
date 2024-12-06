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

use Auth;

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
        $user = Auth::user()->id;
        $top = Topic::all();
        return view('/exam',compact('user','top'));
     }

     public function indexTrial() {
        $user = Auth::user()->id;
        $top = Topic::all();
        return view('/trial',compact('user','top'));
     }

     public function indexResults(){
        $user = Auth::user()->id;
        $top = Topic::all();
        return view('/results',compact('user','top'));
     }

    public function index3(Request $r){
        return $this->generate_exam($r->id);
    }

    public function index4(Request $r){
       return $this->generate_mockexam($r->topic,$r->id);
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
        ->where('exam_type', 0)
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
            $result = $this->generate_q($min, $max, $st->subtopic_id, $n, $user, 0);
            $attemp1 = $result['attempt'];
            if($attemp1!=-1){
                $attemp=$attemp;
            }
        }
     
        if ($attemp > 3) {
            return view('max_attempt'); //Fully Trialled
        }
    
        $ques = array();
        $st = SubTop::where('topic_id', $top)->get();
        $z = 1;
        $ids = array();
        foreach ($st as $st) {
            $i = 0;
            $x = Tes::where('student_id', $user)->where('topic', $st->subtopic_id)->where('exam_type', 0)->latest()->first();
            if($x==NULL){
                continue;
            }
               
            $ids[$z - 1] = $x->id;
            $x = json_decode($x->questions);
            foreach ($x as $x) {
                $y = $this->getQ($x);
                $ques[$z][$i]['id'] = $y->id;
                $ques[$z][$i]['qn'] = $i + 1;
                $ques[$z][$i]['q'] = $y->qdesc;
                $ques[$z][$i]['c1'] = $y->opt1;
                $ques[$z][$i]['c2'] = $y->opt2;
                $ques[$z][$i]['c3'] = $y->opt3;
                $ques[$z][$i]['c4'] = $y->opt4;
                $ques[$z][$i]['c5'] = $y->opt5;
                $i++;
                $totalQuestions++;
            }
            $z++;
           
        }
        $st = Tes::whereIn('topic', $tpcx)->where('student_id', $user)->where('attemp', $attemp)->where('exam_type', 2)->get('topic')->toArray();
        $c = $i;
        $i = 0;
        $j = 0;
        $tops = $z;
        $a = array();
        $ext = 2;
        //change UI to to other one
        return view('trialexam', compact('ques', 'c', 'i', 'j', 'tops', 'a', 'st', 'user', 'ids', 'attemp', 'top', 'time', 'ext', 'totalQuestions','num'));
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