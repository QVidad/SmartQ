@extends('layouts.facultylayout')
@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
        <facultycontentcard title="Create Exam">
            <create-examination :topics="{{ json_encode($topic) }}" :subtopics="{{ json_encode($subtopic) }}"></create-examination>
        </facultycontentcard>
    </div>
</body>
@endsection