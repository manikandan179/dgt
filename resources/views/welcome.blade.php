<!-- resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>


    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <button class="logout-btn" type="submit">Logout</button>
    </form>

</body>
</html>
