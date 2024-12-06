@extends('layouts.facultylayout')
@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
        <facultycontentcard title="Configure Exam">
            <configure-examination :subtopics="{{ json_encode($subtopics) }}" :topics="{{ json_encode($topics) }}" :exam="{{ json_encode($exam) }}" :questions="{{ json_encode($questions) }}"></configure-examination>
        </facultycontentcard>
    </div>
</body>
@endsection