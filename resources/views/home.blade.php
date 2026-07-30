<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   @extends('layouts.app')

   {{-- @section('title', 'Home Page') --}}

   @section('content')
        <h2>Welcome to Home</h2>

        @if(session('success'))
            <div style="color: green"> {{session('success')}} </div>
        @endif

        <p>hello, {{$name ?? 'Guest'}} </p>
   @endsection







</body>
</html>