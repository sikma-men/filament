<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Loket PLN</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* CSS Anda tetap sama */
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Loket PLN</h1>

        {{-- Menampilkan error jika email atau password salah --}}
        @if(session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                });
            </script>
        @endif

        <form method="POST" action="{{ route('loginloket') }}">
            @csrf
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
