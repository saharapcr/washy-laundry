
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Washy Laundry</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f9ff;
            color: #19334d;
        }

        header {
            background: white;
            padding: 20px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px #ddd;
        }

        .logo {
            font-size: 25px;
            font-weight: bold;
            color: #1688d4;
        }

        nav a {
            text-decoration: none;
            margin-left: 20px;
            color: #19334d;
            font-weight: bold;
        }

        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 8%;
            gap: 40px;
            flex-wrap: wrap;
        }

        .hero-content {
            max-width: 550px;
        }

        .hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            color: #087fc1;
        }

        .hero p {
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .buttons a {
            display: inline-block;
            padding: 14px 25px;
            margin-right: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .login {
            background: #1688d4;
            color: white;
        }

        .register {
            background: white;
            color: #1688d4;
            border: 2px solid #1688d4;
        }

        .illustration {
            font-size: 150px;
        }

        .services {
            padding: 50px 8%;
            text-align: center;
            background: white;
        }

        .services h2 {
            color: #087fc1;
            margin-bottom: 30px;
        }

        .service-list {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .service {
            background: #f0f8ff;
            padding: 30px;
            border-radius: 12px;
            width: 220px;
        }

        .service h3 {
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            padding: 25px;
            background: #087fc1;
            color: white;
        }

        @media(max-width: 600px) {
            .hero h1 {
                font-size: 34px;
            }

            .illustration {
                font-size: 90px;
            }
        }
    </style>
</head>

<body>

<header>
    <div class="logo">🫧 Washy Laundry</div>

    <nav>
        <a href="/">Home</a>
        <a href="#layanan">Layanan</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
    </nav>
</header>

<section class="hero">
    <div class="hero-content">
        <h1>Solusi Laundry Praktis dan Terpercaya!</h1>

        <p>
            Washy Laundry hadir untuk membantu pakaian
            kamu tetap bersih, wangi, dan nyaman.
            Nikmati layanan laundry yang mudah,
            cepat, dan berkualitas.
        </p>

        <div class="buttons">
            <a href="{{ route('login') }}" class="login">
                Mulai Sekarang
            </a>

            <a href="{{ route('register') }}" class="register">
                Daftar Akun
            </a>
        </div>
    </div>

    <div class="illustration">🧺</div>
</section>

<section class="services" id="layanan">
    <h2>Layanan Kami</h2>

    <div class="service-list">
        <div class="service">
            <h3>👕 Cuci Kering</h3>
            <p>Pakaian bersih dan siap digunakan.</p>
        </div>

        <div class="service">
            <h3>🧺 Cuci Setrika</h3>
            <p>Pakaian bersih, rapi, dan wangi.</p>
        </div>

        <div class="service">
            <h3>✨ Setrika</h3>
            <p>Pakaian lebih rapi dan nyaman.</p>
        </div>
    </div>
</section>

<footer>
    <p>&copy; 2026 Washy Laundry. All Rights Reserved.</p>
</footer>

</body>
</html>
