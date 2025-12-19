<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Luxury Car Wash</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #2f2f2f;
            --light-gray: #f0f0f0;
            --accent: #e29a00;
            --text-dark: #1f1f1f;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--dark-bg);
            color: var(--text-dark);
            display: flex;
            justify-content: center;
            padding: 24px;
        }

        .page {
            width: min(1100px, 100%);
            background: var(--dark-bg);
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.3);
        }

        .top-bar {
            background: var(--light-gray);
            color: #111;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 18px;
            font-size: 15px;
            gap: 12px;
        }

        .top-bar .left, .top-bar .right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .icon {
            color: #b0006d;
            font-weight: 700;
        }

        .logo-nav {
            background: var(--accent);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 12px 18px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 2px solid #005aa7;
            flex-shrink: 0;
        }

        .logo img { width: 100%; height: 100%; object-fit: cover; }

        nav {
            display: flex;
            gap: 28px;
            font-weight: 600;
            font-size: 20px;
            color: #222;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            color: #1b1b1b;
            transition: opacity 0.2s ease;
        }

        nav a:hover { opacity: 0.75; }

        .hero {
            position: relative;
            height: clamp(320px, 50vw, 620px);
            background: url('https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.38);
        }

        .hero-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            z-index: 1;
            text-align: center;
            padding: 0 24px;
        }

        .hero-text h1 {
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 600;
            line-height: 1.2;
        }

        @media (max-width: 640px) {
            body { padding: 12px; }
            .logo-nav { flex-direction: column; align-items: flex-start; }
            nav { font-size: 18px; gap: 18px; }
            .top-bar { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="top-bar">
            <div class="left">
                <span class="icon">⏰</span>
                <span>Mon-Friday: 8:00–19:00</span>
            </div>
            <div class="right">
                <span class="icon">📞</span>
                <span>+48 600 000 000</span>
                <span style="color:#888;">|</span>
                <span class="icon">✉️</span>
                <span>contact@carwashrepair.com</span>
            </div>
        </div>

        <div class="logo-nav">
            <div class="logo">
                <img src="https://i.imgur.com/aAvpR7q.png" alt="Ronnie's Luxury Car Wash logo">
            </div>
            <nav>
                <a href="#">Home</a>
                <a href="#">About Us</a>
                <a href="#">Store</a>
                <a href="#">Gallery</a>
                <a href="#">Contact Us</a>
            </nav>
        </div>

        <section class="hero">
            <div class="hero-text">
                <h1>Luxury Hand Car Wash &amp; Repair</h1>
            </div>
        </section>
    </div>
</body>
</html>
