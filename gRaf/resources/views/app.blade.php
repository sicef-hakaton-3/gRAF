<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>gRaf</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/master2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.9/css/weather-icons.css">

</head>
<body>

    <nav class="navbar navbar-inverse">
        <a class="navbar-brand" href="{{ route("home") }}">gRaf</a>

        {!! Form::open(['url' => 'location', 'method' => 'get', 'class'=>'row myNavBarInput form-inline float-xs-right', 'role'=>'search']) !!}
        {!! Form::text('city', "", ['class'=>'form-control myNavBarInputElement col-xs-3', 'placeholder'=>'Find a place you wish to visit']) !!}
        {!! Form::text('from', "06-11-2016", ['class'=>'form-control myNavBarInputElement col-xs-3']) !!}

        {!! Form::text('to', "10-11-2016", ['class'=>'col-xs-3 myNavBarInputElement form-control']) !!}
        {!! Form::submit('Find', ['class'=>'col-xs-3 btn btn-primary']) !!}
        {!! Form::close() !!}
    </nav>



    @yield("days")

    <div class="container">
        @yield("content")
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        @yield('js')
    </script>

    @yield('scripts')

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbO_68LlwzHwaW9skP7z-7WfU1KZCTlVQ">
    </script>
</body>
</html>
