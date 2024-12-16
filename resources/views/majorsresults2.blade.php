@extends('layouts.app')
@section('content')
<head>
    {{-- <title>{{$tps}} Scores</title> --}}
    <title>SMARTQ | EXAM RESULT</title>
</head>
<body>
    <div class="card px-5 pb-5 shadow" style="background-color: rgba(0, 0, 0, 0); font-family: Verdana, Geneva, Tahoma, sans-serif;">
        <!-- Greetings Text -->
        <div class="card-header p-4" style="background-color: rgba(0, 0, 0, 0.5); border-top-left-radius: 20px; border-top-right-radius: 20px;">
            <div class="d-flex justify-content-between">
                <div>
                    <p class="h1 p-0 m-0 text-white" style="font-style: italic;">Exam Results</p>
                    <p class="display-4 p-0 m-0 text-white font-weight-bold">Exam 1</p>  
                </div>
                <div class="text-white text-center">
                    <showscore score="{{$totalScore}}" total="{{$totalQuestions}}"/>
                </div>
            </div>
        </div>
        <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
            <h3 class="font-weight-bold">Results and Feedbacks</h3>
            <hr class="bg-light border" />
            <div class="px-5 py-3 justify-content-center">
                {{-- Review Exam Question --}}
                @foreach ($responseScores as $response)
                    {{-- The Subtopic --}}
                    <div class="row">
                        <div class="col-lg-12"> <h2 class="font-weight-bold">Topic: {{ $response['topic']}} </h2> </div>
                        <div class="col-lg-12"> <h5 class="font-weight-bold">Subtopic: {{ $response['response_id'] }}</h5> </div>
                    </div>
                    <ul>
                        Total Score: {{ $response['total_score'] }} / {{ $response['total_point']  }} = {{ ($response['total_score']/$response['total_point'])*100 }}%</li>
                                    @foreach ($response['answers'] as $answer)
                                        {{-- The Results --}}
                                        <div class="row">
                                            <div class="col-1 text-center mr-2">
                                                <h1 class="font-weight-bold">{{ $answer['question_no'] }}</h1>
                                            </div>
                                            <div class="col">
                                                <div class="row">
                                                    <h5>{{ $answer['question_details'] }}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="bg-light border" />
                                        <div class="row">
                                            <div class="col-lg-12 my-2">
                                                
                                                    @if($answer['selected_answer'] == $answer['correct_answer'] )
                                                        <div>
                                                            <i class="bi bi-check-square-fill" style="color: green;"></i> 
                                                            <strong>You chose {{ $answer['selected_answer'] }}</strong>  
                                                        </div>
                                                    @elseif($answer['selected_answer']==0)
                                                        <div>
                                                            <i class="bi bi-x-square" style="color: red;"></i> 
                                                            <strong>You did not answer </strong>   
                                                        </div>
                                                    @else
                                                        <div>
                                                            <i class="bi bi-x-square" style="color: red;"></i> 
                                                            <strong>You chose {{ $answer['selected_answer'] }}</strong>   
                                                        </div>
                                                    @endif
                                                    <div class="my-3">
                                                        @if($answer['selected_answer'] == $answer['correct_answer'] )
                                                            <div class="row pl-2 alert alert-success" style="background-color: rgba(0, 255, 0, 0.4);">
                                                                <p class="font-weight-bold mt-2 pr-2 mb-0 pb-2">Feedback: {{ $answer['feedback']  }}</p>
                                                            </div>
                                                        @else
                                                            <div class="row pl-2 alert alert-danger" style="background-color: rgba(255, 0, 0, 0.4);">
                                                                <p class="font-weight-bold mt-2 pr-2 mb-0 pb-2">Feedback: {{ $answer['feedback'] }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                            </div>
                                        </div>
                                @endforeach 
                        </ul>
                @endforeach
            </div>
    <ul>
        
        
    </ul>
        </div>
    </div>
</body>
</html>
@endsection
