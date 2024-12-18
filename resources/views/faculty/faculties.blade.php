@extends('layouts.facultylayout')
@section('content')
<title>SmartQ Faculty | Faculties Report</title>
<body>
    <div style="">
        <facultycontentcard title="Faculties">
            <faculties :faculties="{{ json_encode($faculties) }}"></faculties>
        </facultycontentcard>
    </div>
</body>
@endsection