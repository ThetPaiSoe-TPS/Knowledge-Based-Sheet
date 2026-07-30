<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>User form</h1>
    <form action="{{route('users.store')}}" method="POST">
        @csrf

        <input type="text" name="name" id="" value="{{ old('name')}}">
        @error('name')
            <div style="color: red"> {{$message}} </div>
        @enderror
        <input type="email" name="email" id="" value="{{old('email')}}">
         @error('email')
            <div style="color: red"> {{$message}} </div>
        @enderror
        <input type="password" name="password" id="" >
         @error('password')
            <div style="color: red"> {{$message}} </div>
        @enderror
        <button type="submit">Send</button>
    
    </form>
   
</body>
</html>