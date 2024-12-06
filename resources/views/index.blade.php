<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Laravel App</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
        <a href="{{ route('index3', ['id' => $user]) }}" class="btn btn-primary">
            Examination
        </a>
        <br><br><br><br><br>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="mainDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Mock Exam
            </button>
            <div class="dropdown-menu" aria-labelledby="mainDropdown">
                @foreach($top as $top)
                <a class="dropdown-item" href="{{ route('majorexam', ['id' => $user,'topic'=>$top->topic_id]) }}">{{$top->topic_name}}</a>
                @endforeach
               
            </div>
        </div>
 <!-- Include jQuery -->
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <!-- Include Popper.js (Version 1.16.1) -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
