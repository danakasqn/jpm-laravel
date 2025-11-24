<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Panel zarządzania mieszkaniami</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            :root {
                --bg: #0f172a;
                --card: #0b1021;
                --accent: #22d3ee;
                --muted: #94a3b8;
                --border: #1f2937;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
                background: radial-gradient(circle at 20% 20%, rgba(34, 211, 238, 0.2), transparent 30%),
                    radial-gradient(circle at 80% 0%, rgba(14, 165, 233, 0.16), transparent 25%),
                    #020617;
                color: #e2e8f0;
                min-height: 100vh;
            }

            a { color: inherit; text-decoration: none; }

            .page {
                max-width: 1200px;
                margin: 0 auto;
                padding: 32px 20px 64px;
            }

            .hero {
                background: linear-gradient(145deg, rgba(34, 211, 238, 0.12), rgba(59, 130, 246, 0.1));
                border: 1px solid rgba(148, 163, 184, 0.18);
                border-radius: 24px;
                padding: 28px;
                box-shadow: 0 25px 80px rgba(0, 0, 0, 0.45);
            }

            .hero h1 {
                margin: 0 0 12px;
                font-size: 32px;
                line-height: 1.1;
                letter-spacing: -0.5px;
            }

            .hero p { color: var(--muted); margin: 0 0 20px; max-width: 680px; }

            nav {
                display: flex;
                gap: 12px;
                justify-content: flex-end;
                margin-bottom: 16px;
            }

            nav a {
                border: 1px solid rgba(148, 163, 184, 0.25);
                padding: 10px 16px;
                border-radius: 12px;
                color: #e2e8f0;
                font-weight: 600;
                transition: border-color 0.2s, background 0.2s, transform 0.2s;
            }

            nav a:hover { border-color: var(--accent); transform: translateY(-1px); }

            .btn-primary {
                background: linear-gradient(120deg, #22d3ee, #3b82f6);
                border: none;
                color: #0b1021;
                padding: 12px 18px;
                border-radius: 12px;
                font-weight: 700;
                letter-spacing: 0.2px;
                display: inline-flex;
                align-items: center;
                gap: 10px;
                box-shadow: 0 15px 40px rgba(34, 211, 238, 0.32);
            }

            .btn-secondary {
                border: 1px solid rgba(148, 163, 184, 0.28);
                color: #e2e8f0;
                padding: 12px 18px;
                border-radius: 12px;
                font-weight: 700;
                background: rgba(15, 23, 42, 0.6);
            }

            .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 16px;
                margin: 22px 0 10px;
            }

            .card {
                background: var(--card);
                border: 1px solid var(--border);
                border-radius: 18px;
                padding: 18px;
                box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.02), 0 20px 35px rgba(0, 0, 0, 0.35);
            }

            .card h3 { margin: 0 0 8px; font-size: 18px; }
            .card p { margin: 0; color: var(--muted); line-height: 1.5; }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 10px;
                border-radius: 999px;
                background: rgba(34, 211, 238, 0.12);
                border: 1px solid rgba(34, 211, 238, 0.35);
                color: #67e8f9;
                font-weight: 600;
                font-size: 12px;
                letter-spacing: 0.4px;
            }

            .stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 10px;
                margin: 16px 0;
            }

            .stat {
                border: 1px dashed rgba(148, 163, 184, 0.4);
                padding: 14px 16px;
                border-radius: 14px;
                background: rgba(11, 16, 33, 0.7);
            }

            .stat .value { font-size: 24px; font-weight: 700; margin-bottom: 4px; color: #e0f2fe; }
            .stat .label { color: var(--muted); font-size: 13px; }

            .flow {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 14px;
                margin: 10px 0 6px;
            }

            .flow-step { position: relative; }
            .flow-step::before {
                content: "";
                position: absolute;
                left: -12px;
                top: 16px;
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--accent);
                box-shadow: 0 0 0 6px rgba(34, 211, 238, 0.18);
            }

            .flow-step h4 { margin: 0 0 6px; }
            .flow-step ul { margin: 0; padding-left: 16px; color: var(--muted); line-height: 1.55; }

            .checklist {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 10px;
                margin-top: 12px;
            }

            .check-item {
                display: flex;
                align-items: flex-start;
                gap: 8px;
                color: var(--muted);
            }

            .dot {
                width: 10px;
                height: 10px;
                border-radius: 50%;
                background: linear-gradient(120deg, #22d3ee, #3b82f6);
                margin-top: 4px;
            }

            footer { margin-top: 24px; color: var(--muted); font-size: 13px; text-align: center; }

            @media (max-width: 768px) {
                .hero { padding: 22px; }
                nav { justify-content: center; }
                .hero h1 { font-size: 26px; }
            }
        </style>
    @endif
</head>
<body>
    <div class="page">
        <nav>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Przejdź do panelu</a>
                @else
                    <a href="{{ route('login') }}">Logowanie</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Rejestracja</a>
                    @endif
                @endauth
            @endif
        </nav>

        <section class="hero">
            <div class="pill">Zarządzanie wynajmem • Finanse • Podatki</div>
            <h1>Jedno miejsce do obsługi mieszkań, najemców i przepływów finansowych</h1>
            <p>Monitoruj stan lokali, przypisuj wielu najemców do jednego mieszkania, zapisuj wszystkie przychody i wydatki, rozliczaj podatki i miej pewność, że żadne zobowiązanie nie zostanie pominięte.</p>
            <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:18px;">
                <a class="btn-primary" href="{{ Route::has('login') ? route('login') : '#' }}">Rozpocznij pracę</a>
                <a class="btn-secondary" href="{{ url('/dashboard') }}">Zobacz panel</a>
            </div>
            <div class="stats">
                <div class="stat">
                    <div class="value">20+ mieszkań</div>
                    <div class="label">Pełna ewidencja lokali z historią najemców</div>
                </div>
                <div class="stat">
                    <div class="value">Wiele osób</div>
                    <div class="label">Dowolna liczba najemców przypisana do jednego mieszkania</div>
                </div>
                <div class="stat">
                    <div class="value">Finanse</div>
                    <div class="label">Przychody, wydatki, faktury, podatki i opłaty w jednym miejscu</div>
                </div>
            </div>
        </section>

        <div class="grid">
            <div class="card">
                <h3>Centralna baza mieszkań</h3>
                <p>Opisuj lokale, stan wyposażenia, aktywnych i historycznych najemców, umowy oraz wymagane opłaty.</p>
            </div>
            <div class="card">
                <h3>Profile najemców</h3>
                <p>Dodawaj wielu najemców do jednego mieszkania, zapisuj dane kontaktowe, terminy płatności i uwagi.</p>
            </div>
            <div class="card">
                <h3>Finanse i dokumenty</h3>
                <p>Rejestruj faktury, przychody i wydatki, integruj operacje z podatkami i twórz harmonogramy opłat.</p>
            </div>
            <div class="card">
                <h3>Podatki i rozliczenia</h3>
                <p>Podgląd podatku z podziałem na mieszkanie i wynajmującego, śledzenie obowiązków wobec urzędów.</p>
            </div>
        </div>

        <h2 style="margin: 26px 0 12px;">Pełny przepływ informacji finansowych</h2>
        <div class="flow">
            <div class="card flow-step">
                <h4>1. Dane najmu</h4>
                <ul>
                    <li>Przypisanie mieszkań i najemców.</li>
                    <li>Parametry umowy, wysokość czynszu, kaucje.</li>
                    <li>Automatyczne terminy płatności i rozliczenia mediów.</li>
                </ul>
            </div>
            <div class="card flow-step">
                <h4>2. Rejestr faktur i wydatków</h4>
                <ul>
                    <li>Dodawanie dokumentów kosztowych i przychodowych.</li>
                    <li>Kategoryzacja (przychody, wydatki, podatki, opłaty stałe).</li>
                    <li>Statusy płatności i przypomnienia.</li>
                </ul>
            </div>
            <div class="card flow-step">
                <h4>3. Podsumowanie i podatki</h4>
                <ul>
                    <li>Zestawienie salda dla każdego mieszkania.</li>
                    <li>Wyliczenie podatku dla wynajmującego z podziałem na lokale.</li>
                    <li>Raporty miesięczne i zamykanie okresów.</li>
                </ul>
            </div>
        </div>

        <div class="card" style="margin-top: 16px;">
            <h3 style="margin-top:0;">Co zyskujesz?</h3>
            <div class="checklist">
                <div class="check-item">
                    <div class="dot"></div>
                    <div>Jedno spójne źródło danych o mieszkaniach, najemcach i rozliczeniach.</div>
                </div>
                <div class="check-item">
                    <div class="dot"></div>
                    <div>Szybkie dodawanie przychodów i wydatków z przypisaniem do konkretnego lokalu.</div>
                </div>
                <div class="check-item">
                    <div class="dot"></div>
                    <div>Kontrola nad podatkami i terminami opłat urzędowych.</div>
                </div>
                <div class="check-item">
                    <div class="dot"></div>
                    <div>Gotowe do pracy widoki: mieszkania, najemcy, finanse, ustawienia kategorii.</div>
                </div>
            </div>
        </div>

        <footer>
            Zaloguj się, aby przejść do panelu i wprowadzić pierwsze mieszkanie, najemców oraz operacje finansowe.
        </footer>
    </div>
</body>
</html>
