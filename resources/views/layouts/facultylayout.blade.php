<!DOCTYPE html>
<html>
<head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <div style="background-image: url('{{ asset('assets/background.png') }}'); 
            background-size: cover; 
            background-repeat: no-repeat; 
            background-position: center center; 
            background-attachment: fixed;
            min-height: 100vh; ">
    <div id="app">
        <navbar></navbar>
        <!-- <secondnavbar></secondnavbar> -->
        <facultynavbar></facultynavbar>
        <div>
            @yield('content')
        </div>
    </div>
</div>

</body>
<script src="{{asset('/js/app.js')}}">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>
