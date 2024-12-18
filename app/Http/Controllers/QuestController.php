<?php

namespace App\Http\Controllers;

use App\Qs;
use App\SubTop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index1()
    {
        //
        $user = 1;
        $subtopic=SubTop::all();
        return view('createquestion',compact('user','subtopic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterSub = $request->input('filterByTopic');
        
        $subtopic = SubTop::all();

        $q = Qs::where('qdesc', 'like', '%' . $search . '%')
            ->orWhere('topic_id', $filterSub)
            ->paginate(5);

        return view('questions', compact('q', 'search', 'subtopic'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        //
        Qs::create($r->all());
        return redirect()->back()->with('success','Question created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Qs  $qs
     * @return \Illuminate\Http\Response
     */
    public function show(Qs $qs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Qs  $qs
     * @return \Illuminate\Http\Response
     */
    public function edit(Qs $qs)
    {
        //
        $user = 1;
        $subtopic=SubTop::all();
        return view('editquestion', compact('qs','subtopic','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Qs  $qs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r)
    {
        //
        $x=0;
        $qs=Qs::find($r->id);
        if($r->qdesc){
            $qs->qdesc=$r->qdesc;
            $x++;
        }
        if($r->opt1){
            $qs->opt1=$r->opt1;
            $x++;
        }
        if($r->opt2){
            $qs->opt2=$r->opt2;
            $x++;
        }
        if($r->opt3){
            $qs->opt3=$r->opt3;
            $x++;
        }
        if($r->opt4){
            $qs->opt4=$r->opt4;
            $x++;
        }
        if($r->opt5){
            $qs->opt5=$r->opt5;
            $x++;
        }
        if($r->reff){
            $qs->reff=$r->reff;
            $x++;
        }
        if($r->ans>0){
            $qs->ans=$r->ans;
            $x++;
        }
        if($r->topic_id>0){
            $qs->topic_id=$r->topic_id;
            $x++;
        }
        if($r->status==0){
            $qs->status=$r->status;
            $x++;
        }
        if($x>0){
            $qs->created_by=$r->created_by;
            $qs->save();
            return redirect()->back()->with('success','Question updated successfully.');
        }
        //return $qs;
        return redirect()->back()->with('success','No Field of the Question has updated successfully.');
       
  
        return $r;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Qs  $qs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qs $qs)
    {
        //
        $qs->delete();
        return back()->with('success', 'Post deleted successfully.');
    }

    public function downloadTemplate() {
        return Storage::disk('local')->download('/template/Question Bank Template.xlsx');
    }
}
