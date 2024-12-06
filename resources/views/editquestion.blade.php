<!-- resources/views/create-question.blade.php -->
@extends('layouts.facultylayout')

@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
        <facultycontentcard title="Edit Question">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
            <form action="{{ route('questions.update', $qs->id) }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="qdesc">Question Description</label>
                    <input type="text" class="form-control" id="qdesc" name="qdesc" placeholder="{{$qs->qdesc}}">
                </div>

                <div class="form-group">
                    <label for="opt1">Option 1</label>
                    <input type="text" class="form-control" id="opt1" name="opt1" placeholder="{{$qs->opt1}}">
                </div>

                <div class="form-group">
                    <label for="opt2">Option 2</label>
                    <input type="text" class="form-control" id="opt2" name="opt2" placeholder="{{$qs->opt2}}">
                </div>

                <div class="form-group">
                    <label for="opt3">Option 3</label>
                    <input type="text" class="form-control" id="opt3" name="opt3" placeholder="{{$qs->opt3}}">
                </div>

                <div class="form-group">
                    <label for="opt4">Option 4</label>
                    <input type="text" class="form-control" id="opt4" name="opt4" placeholder="{{$qs->opt4}}">
                </div>

                <div class="form-group">
                    <label for="opt5">Option 5</label>
                    <input type="text" class="form-control" id="opt5" name="opt5" placeholder="{{$qs->opt5}}">
                </div>

                <div class="form-group">
                    <label for="reff">Reference</label>
                    <textarea class="form-control" id="reff" name="reff" rows="3" placeholder="{{$qs->reff}}" ></textarea>
                </div>

                <div class="form-group">
                    <label for="ans">Correct Answer</label>
                    <select class="form-control select2" id="ans" name="ans">
                        <option value="0">Select Correct Answer</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                        <option value="4">Option 4</option>
                        <option value="5">Option 5</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="topic_id">Topic</label>
                    <select class="form-control select2" id="topic_id" name="topic_id">
                        <option value="0">Select Topic</option>
                        @foreach($subtopic as $st)
                        <option value="{{$st->subtopic_id}}">{{$st->name}}</option>
                        @endforeach
                        <!-- Add more topics as needed -->
                    </select>
                </div>

                
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control select2" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Deactivate</option>
                    </select>
                </div>

                <input type="hidden" id="created_by" name="created_by" value="{{ $user }}">
                <input type="hidden" id="id" name="id" value="{{ $qs->id }}">
                <button type="submit" class="btn btn-primary">Update Question</button>
            </form>
      </facultycontentcard>
    </div>
</body>
@endsection

@section('scripts')

@endsection

