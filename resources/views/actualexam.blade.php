@extends('layouts.app')
@section('content')
<title>SMARTQ| EXAM </title>
    <body class="antialiased">
        <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
            <!-- Greetings Text -->
            <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="h1 p-0 m-0 text-white" style="font-style: italic;">Trial Exam</p>
                        <p class="display-4 p-0 m-0 text-white font-weight-bold">Category here</p>     
                    </div>
                </div>
            </div>
            <div>
              <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
                <div class="px-5 py-3 justify-content-center">
                    <!-- Top Part Grid-->
                    <div class="row ">
                        <div class="col-10"><progressbar :progress="{{$num}}"/></div>
                        <div class="col-2"><timer :time="{{ $time * 3600 }}"/></div>
                    </div>
                    {{-- The Exam Content --}}
                    <div class="pr-4">
                        <h3 class="font-weight-bold my-3">Subtopic: </h3>
                        <form id="autoSubmitForm" class="contact-form row" action="{{ route('stored') }}" method="POST">
                            {{ csrf_field() }}  
                            <input id="id" name="id" class="input-text js-input" type="hidden" value="{{$user}}">
                            <input id="extype" name="extype" class="input-text js-input" type="hidden" value="{{$ext}}">
                            <input id="attemp" name="attemp" class="input-text js-input" type="hidden" value="{{$attemp}}">
                            <input id="ids" name="ids" class="input-text js-input" type="hidden"  value="{{ serialize($ids) }}">

                        @for($i=1;$i<$tops;$i++)
                            <div class="row">
                                <div class="form-field col-lg-12">                       
                                    </div>
                                    </div>
                            @for($j=0;$j<$c;$j++)
                            <div class="row">
                            <div class="form-field col-lg-12">
                            {{-- The Questions --}}
                            <div class="row">
                                <div class="col-1 text-center mr-2">
                                    <div class="justify-content-center">
                                        <h1 class="font-weight-bold">{{ $num++ }}</h1>
                                        <p>out of {{ $totalQuestions }}</p>
                                    </div>
                                    
                                </div>
                                <div class="col">
                                    <div class="form-field col-lg-12 pb-0">                   
                                        <h5 class="label" for="name"><h5>{{ $ques[$i][$j]['q' ]}}</h5></label>
                                        <hr class="bg-light border p-0 mt-0"/>
                                        <div class="form-check my-2">
                                            <input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="0" checked hidden>
                                        </div>
                                        <div class="form-check my-2">
                                            <h5><input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="1" >{{$ques[$i][$j]['c1']}}</h5>
                                            <label class="form-check-label" for="radio1"></label>
                                        </div>
                                        <div class="form-check my-2">
                                            <h5><input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="2">{{$ques[$i][$j]['c2']}}</h5>
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>        
                                        <div class="form-check my-2">
                                            <h5><input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="3">{{$ques[$i][$j]['c3']}}</h5>
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>   
                                        <div class="form-check my-2">
                                            <h5><input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="4">{{$ques[$i][$j]['c4']}}</h5>
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>              
                                        <div class="form-check my-2">
                                            <h5><input type="radio" class="form-check-input" id="radio{{$st[$i-1]['topic_id']}}{{$j+1}}" name="radio[{{$st[$i-1]['topic_id']}}][{{$j+1}}]" value="5">{{$ques[$i][$j]['c5']}}</h5>
                                            <label class="form-check-label" for="radio2"></label>
                                        </div>      
                                    </div>
                                </div>
                            </div>
                            @endfor
                        @endfor
                              <div class="d-flex justify-content-between pt-3">
                                <div></div>
                                {{-- <div>
                                  <a class="btn px-3 text-white" style="background-color: #292B4E;">
                                    <i class="bi bi-arrow-left"></i>
                                    Previous
                                  </a>
                                  <a class="btn px-9 text-white" style="background-color: #292B4E;">
                                    Next
                                    <i class="bi bi-arrow-right"></i>
                                  </a>              
                                </div> --}}
                                <button class="btn btn-success px-3" type="submit">
                                    Finish Exam
                                    <i class="bi bi-check-lg"></i>
                                </button> 
                                </div> 
                              </div>      
                                     
                        </form>   
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
    </body>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
         let countdownTime = {{$time}} * 60 * 60; // Countdown time in seconds (2 hours)
         const countdownDisplay = document.getElementById("countdown");
         const form = document.getElementById("autoSubmitForm");

         // Function to update the countdown and submit the form
         function updateCountdown() {
             let hours = Math.floor(countdownTime / 3600);
             let minutes = Math.floor((countdownTime % 3600) / 60);
             let seconds = countdownTime % 60;

             // Format the time to display as HH:MM:SS
             hours = hours < 10 ? '0' + hours : hours;
             minutes = minutes < 10 ? '0' + minutes : minutes;
             seconds = seconds < 10 ? '0' + seconds : seconds;

             countdownDisplay.textContent = `Time : ${hours}:${minutes}:${seconds}`;

             if (countdownTime > 0) {
                 countdownTime--;
             } else {
                 form.submit();
             }
         }

         // Update countdown every second
         setInterval(updateCountdown, 1000);
     });
 </script>