@extends('layouts.facultylayout')
@section('content')
<title>SmartQ Faculty | Students Report</title>
<body>
    <div style="">
        <facultycontentcard title="Students">
            <faculty-students :students="{{ json_encode($students) }}"></faculty-students>
        </facultycontentcard>
    </div>
</body>
@endsection