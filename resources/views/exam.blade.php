@extends('layouts.app')
@section('content')
<title>SMARTQ | EXAM </title>
<body>
    <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
        <!-- Greetings Text -->
        <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
          <p class="h1 p-0 m-0 text-white" style="font-style: italic;">Welcome!</p>
          <p class="display-4 p-0 m-0 text-white" style="font-weight: bold;">{{ auth()->user()->name }}</p>
        </div>
        <div>
          <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
            <h3 class="card-title" style="font-weight: bold;">Available Exams</h3>
            <div class="px-5 py-3 justify-content-center">
              <!-- card grid -->
              <div class="container-fluid justify-content-center p-0 m-0">
                <div class="row row-cols-xl-4 row-cols-lg-3 row-cols-md-2 ">
                @foreach($top as $number)
                  <div class="grid-item">
                    <div class="col pb-3">
                        <examscard 
                            category="{{ $number->exam_name}}" 
                            examLink="{{ route('majorexam', ['id' => $user,'examid'=> $number->exam_id]) }}"
                        />
                    </div>
                  </div>
                @endforeach
                <!-- <div class="grid-item">
                  <div class="col pb-3">
                      <examscard 
                          category="Actual" 
                          examLink="{{ route('majorexam', ['id' => $user,'examid' => 2]) }}"
                      />
                  </div>
                </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
  
@endsection
