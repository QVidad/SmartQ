@extends('layouts.facultylayout')
@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
      <facultycontentcard title="Upload File">
      <div class="container">
        @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
        @endif
        <form action="{{ route('posts.store') }}" method="post" name="importform"
            enctype="multipart/form-data">
              @csrf
            <div class="form-group">
              <label for="file">File:</label>
              <input id="file" type="file" name="file" class="">
            </div>	
            <button class="btn btn-success">Import File</button>
          </form>
        </div>
      </facultycontentcard>
    </div>
</body>
@endsection