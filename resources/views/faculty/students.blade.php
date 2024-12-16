@extends('layouts.facultylayout')
@section('content')
<title>SMARTQ FACULTY | STUDENT </title>
<body>
    <div style="">
        <facultycontentcard title="Students">
            <faculty-students :students="{{ json_encode($students) }}"></faculty-students>
        </facultycontentcard>
    </div>
</body>
@endsection