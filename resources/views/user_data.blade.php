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
    <form action="/user" method="POST">
        @csrf

        <input type="text" name="name" id="">
        <input type="email" name="email" id="">
        <button type="submit">Send</button>
    
    </form>
</body>
</html>