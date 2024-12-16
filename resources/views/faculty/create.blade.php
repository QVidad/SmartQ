@extends('layouts.facultylayout')
@section('content')
<title>SMARTQ FACULTY | CREATE EXAM </title>
<body>
    <div style="">
        <facultycontentcard title="Create Exam">
            <create-examination :topics="{{ json_encode($topic) }}" :subtopics="{{ json_encode($subtopic) }}"></create-examination>
        </facultycontentcard>
    </div>
</body>
@endsection