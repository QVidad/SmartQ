@extends('layouts.facultylayout')

@section('content')
<title>PLE-REAP FACULTY | DASHBOARD </title>
<body>
    <div style="">
        <facultycontentcard title="Question Bank">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex">
                    <div class="d-flex mr-auto">
                        <form action="{{ route('questions.index') }}" method="GET" class="d-flex">
                            <input type="text" id="search-input" name="search" class="form-control m-2 p-2" value="{{ request('search') }}" placeholder="Search Questions...">

                            <select name="filterByTopic" class="form-control m-2 p-2">
                                <option value="">Filter by Topic</option>
                                @foreach($subtopic as $sub)
                                    <option value="{{ $sub->subtopic_id }}" {{ request('filterByTopic') == $sub->subtopic_id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary m-2">Search</button>
                        </form>
                    </div>
                    
                    <div class="d-flex">
                        <a href="/download/template" class="m-2 p-2 btn btn-success btn-sm"><i class="bi bi-download"></i> Download Template</a>
                        <a href="/uploadfile" class="m-2 p-2 btn btn-secondary btn-sm"><i class="bi bi-plus-square"></i> Upload File</a>
                        <a href="/createquestion" class="m-2 p-2 btn btn-primary btn-sm"><i class="bi bi-plus-square"></i> Add Question</a>
                    </div>
                </div>
                
                <table class="table table-bordered table-responsive table-stripe">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Option 1</th>
                            <th>Option 2</th>
                            <th>Option 3</th>
                            <th>Option 4</th>
                            <th>Option 5</th>
                            <th>Answer</th>
                            <th>Refference</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($q->count())
                        @foreach($q as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                            @if(strlen($post->qdesc) > 100 )
                                {{ Str::limit($post->qdesc, 100) }}
                                <span class="read-more">Read More</span>
                                <span class="full-text" style="display:none;">{{ $post->qdesc }}</span>
                            @else
                                {{ $post->qdesc }}
                            @endif  
                            </td>
                            <td>{{ $post->opt1 }}</td>
                            <td>{{ $post->opt2 }}</td>
                            <td>{{ $post->opt3 }}</td>
                            <td>{{ $post->opt4 }}</td>
                            <td>{{ $post->opt5 }}</td>
                            <td>Option {{ $post->ans }}</td>
                            <td>
                            @if(strlen($post->reff) > 100 )
                                {{ Str::limit($post->reff, 100) }}
                                <span class="read-more">Read More</span>
                                <span class="full-text" style="display:none;">{{ $post->reff }}</span>
                            @else
                                {{ $post->reff }}
                            @endif    
                            </td>
                            <td class="btn-group">
                                <!-- Edit Button -->
                                <a href="{{ route('questions.edit', $post->id) }}" class="mx-1 btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>

                                <!-- Delete Button -->
                                <form action="{{ route('questions.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="mx-1 btn btn-danger btn-sm" onclick="return confirm('Are you sure?');"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <p>No results found.</p>
                    @endif
                    </tbody>
                </table>

                <!-- Pagination Links with search query persistence -->
                {{ $q->appends(['search' => request('search')])->links() }}
            </div>
      </facultycontentcard>
    </div>
</body>
@endsection
