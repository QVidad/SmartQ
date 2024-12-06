@extends('layouts.facultylayout')
@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
        <facultycontentcard title="Students">
            <faculty-students :students="{{ json_encode($students) }}"></faculty-students>
        </facultycontentcard>
    </div>
</body>
@endsection