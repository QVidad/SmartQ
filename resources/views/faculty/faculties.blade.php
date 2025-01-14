@extends('layouts.facultylayout')
@section('content')
<title>SMARTQ ADMIN</title>
<body>
    <div style="">
        <facultycontentcard title="Manage Faculty">
            <faculties :faculties="{{ json_encode($faculties) }}"></faculties>
        </facultycontentcard>
    </div>
</body>
@endsection