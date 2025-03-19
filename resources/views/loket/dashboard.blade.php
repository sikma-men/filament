<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Loket</title>
</head>

<body>
    <a href="{{ route('carinokontrol') }}">Cari Data Pemakaian</a>
    <a href="{{ '/carinokontrol' }}">Cari Data Pemakaian</a>
    <br>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>

</html>
