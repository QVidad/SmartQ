@extends('layouts.app')
@section('content')
<title>PLE-REAP ASSESMENT | EXAM - CATEGORY </title>
<body>
    <takeexam first="Pharmacology" second="General Principles of Pharmacology"></takeexam>
</body>
@endsection
<script>
export default {
    name: 'TakeExam',
    props: {
      first: {
        type: String,
        required: true
      },
      second: {
        type: String,
        required: true
      }
    }
  }
  </script>

  