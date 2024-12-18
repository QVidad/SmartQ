@extends('layouts.app')
@section('content')
<title>SMARTQ | EXAM RESULT</title>

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
                    <showscore score="{{ $total }}" total="{{ $totalQuestions }}"/>
                </div>
            </div>
        </div>
        <div class="card-body" style="background-color: #f5f5f5; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px;">
            <h3 class="font-weight-bold">Results and Feedbacks</h3>
            <hr class="bg-light border" />
            <div class="px-5 py-3 justify-content-center">
                {{-- Review Exam Question --}}
                @foreach($ques as $q)
                {{-- The Subtopic --}}
                @if($q["no"]%$i==1)
                <div class="row">
                    <div class="col-lg-12"> <h2 class="font-weight-bold">{{ $q['tops'] }}</h2> </div>
                </div>
                @endif
                {{-- The Results --}}
                <div class="row">
                    <div class="col-1 text-center mr-2">
                        <h1 class="font-weight-bold">{{ $q["no"] }}</h1>
                    </div>
                    <div class="col">
                        <div class="row">
                            <h5>{{ $q["desc"] }}</h5>
                        </div>
                    
                    <hr class="bg-light border" />
                    {{-- The Answers --}}
                    @for($i = 1; $i <= 5; $i++)
                            <div class="row">
                                <div class="col-lg-12 my-2">
                                    @if($q['stans'] == $i)
                                        @if($q['stans'] == $q['ans'])
                                            <i class="bi bi-check-square-fill" style="color: green;"></i>
                                        @else
                                            <i class="bi bi-x-square" style="color: red;"></i>
                                        @endif
                                        @elseif($q['ans'] == $i)
                                            <i class="bi bi-check-square-fill" style="color: green;"></i>
                                        @else
                                            <i class="bi bi-square"></i>
                                    @endif
                                    {{ $q["opt$i"] }}
                                </div>
                            </div>
                    @endfor
                    @if($q['stans']==0)
                        <div class="row">
                            <div class="col-lg-12"> 
                                <i class="bi bi-x-square" style="color: red;"></i> Did Not Answer
                            </div>
                        </div>
                    @endif
                    {{-- The Feedbacks --}}
                    <div class="my-3">
                        @if($q['stans'] == $q['ans'])
                            <div class="row pl-2 alert alert-success" style="background-color: rgba(0, 255, 0, 0.4);">
                                <p class="font-weight-bold mt-2 pr-2 mb-0 pb-2">Feedback: {{ $q['reff'] }}</p>
                            </div>
                        @else
                            <div class="row pl-2 alert alert-danger" style="background-color: rgba(255, 0, 0, 0.4);">
                                <p class="font-weight-bold mt-2 pr-2 mb-0 pb-2">Feedback: {{ $q['reff'] }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12"> 
             
                    <br>
                </div>
            </div>
            
            @endforeach
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12"> <h2></h2> </div>
            </div>

            
     
         
        </div>
    <script>
        // Function to refresh the page
        function refreshPage() {
            if (!sessionStorage.getItem('refreshed')) {
                // Set the flag in session storage to prevent multiple refreshes
                sessionStorage.setItem('refreshed', 'true');
                // Refresh the page after 1 second
                setTimeout(function() {
                    location.reload();
                }, 1000); // 1000 milliseconds = 1 second
            }
        }
        // Call the function to refresh the page
        refreshPage();
    </script>
</body>
@endsection