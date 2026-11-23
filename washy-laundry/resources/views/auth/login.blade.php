
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Washy Laundry</title>
</head>
<body>
    <h2>Login Washy Laundry</h2>

    @if ($errors->any())
        <p style="color:red">
            {{ $errors->first() }}
        </p>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit">Login</button>
    </form>

    <p>Belum punya akun?
        <a href="{{ route('register') }}">Daftar</a>
    </p>
</body>
</html>
