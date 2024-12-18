@extends('layouts.facultylayout')
@section('content')
<title>SMARTQ FACULTY | DASHBOARD </title>
<body>
    <div style="">
      <facultycontentcard title="Dashboard">
        <dashboard :data="{{ json_encode($results) }}"/>
      </facultycontentcard>
    </div>
</body>
@endsection