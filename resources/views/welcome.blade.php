<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OgrodFlow — Projektowanie ogrodów</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .hero-bg {
            background:
                radial-gradient(circle at 10% 10%, rgba(132, 204, 22, 0.25), transparent 45%),
                radial-gradient(circle at 80% 20%, rgba(34, 197, 94, 0.25), transparent 40%),
                linear-gradient(160deg, #052e16 0%, #14532d 50%, #052e16 100%);
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">
    <header class="hero-bg min-h-screen">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-6 py-6 lg:px-8">
            <span class="text-xl font-semibold tracking-wide">OgrodFlow</span>
            <div class="hidden gap-6 text-sm md:flex">
                <a href="#oferta" class="hover:text-lime-300">Oferta</a>
                <a href="#realizacje" class="hover:text-lime-300">Realizacje</a>
                <a href="#kontakt" class="hover:text-lime-300">Kontakt</a>
            </div>
            <a href="#kontakt" class="rounded-full bg-lime-400 px-4 py-2 text-sm font-semibold text-zinc-900 hover:bg-lime-300">Bezpłatna wycena</a>
        </nav>

        <section class="mx-auto grid max-w-6xl gap-10 px-6 pb-16 pt-14 lg:grid-cols-2 lg:items-center lg:px-8 lg:pt-20">
            <div>
                <p class="mb-4 inline-flex rounded-full border border-lime-300/30 bg-lime-300/10 px-3 py-1 text-xs font-medium uppercase tracking-[0.2em] text-lime-200">
                    Projektowanie i pielęgnacja ogrodów
                </p>
                <h1 class="text-4xl font-bold leading-tight sm:text-5xl lg:text-6xl">
                    Tworzymy <span class="text-lime-300">zielone ogrody</span>, w których chcesz spędzać każdy dzień.
                </h1>
                <p class="mt-6 max-w-xl text-base text-zinc-200/90 sm:text-lg">
                    Od koncepcji po realizację — zakładamy nowoczesne ogródki przydomowe, systemy nawadniania i strefy relaksu dopasowane do Twojego stylu życia.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="#kontakt" class="rounded-full bg-lime-400 px-6 py-3 text-sm font-semibold text-zinc-900 hover:bg-lime-300">Umów konsultację</a>
                    <a href="#realizacje" class="rounded-full border border-zinc-200/30 px-6 py-3 text-sm font-semibold hover:border-lime-300 hover:text-lime-300">Zobacz realizacje</a>
                </div>
            </div>
            <div class="glass rounded-3xl border border-white/20 p-6 shadow-2xl shadow-lime-950/40">
                <h2 class="text-lg font-semibold text-lime-200">Dlaczego klienci wybierają OgrodFlow?</h2>
                <ul class="mt-5 space-y-4 text-sm text-zinc-100/90">
                    <li>✓ Indywidualny projekt 2D/3D i lista nasadzeń.</li>
                    <li>✓ Kompleksowa realizacja: trawnik, rabaty, taras, oświetlenie.</li>
                    <li>✓ Stała opieka ogrodnicza i sezonowe przeglądy.</li>
                </ul>
                <div class="mt-6 rounded-2xl bg-zinc-900/50 p-4 text-sm">
                    <p class="text-zinc-300">Średni czas realizacji:</p>
                    <p class="mt-1 text-2xl font-bold text-lime-300">14–21 dni</p>
                </div>
            </div>
        </section>
    </header>

    <main>
        <section id="oferta" class="mx-auto max-w-6xl px-6 py-20 lg:px-8">
            <h2 class="text-3xl font-semibold sm:text-4xl">Nasza oferta</h2>
            <p class="mt-3 max-w-2xl text-zinc-400">Budujemy ogródki, które są piękne, łatwe w utrzymaniu i gotowe na każdą porę roku.</p>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                    <h3 class="text-lg font-semibold">Projekt ogrodu</h3>
                    <p class="mt-3 text-sm text-zinc-400">Koncepcja, wizualizacja, dobór roślin i materiałów zgodnych z budżetem.</p>
                </article>
                <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                    <h3 class="text-lg font-semibold">Realizacja i nasadzenia</h3>
                    <p class="mt-3 text-sm text-zinc-400">Prace ziemne, systemy nawadniania, trawniki, rabaty, pergole i ścieżki.</p>
                </article>
                <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">
                    <h3 class="text-lg font-semibold">Opieka sezonowa</h3>
                    <p class="mt-3 text-sm text-zinc-400">Przycinanie, nawożenie, odchwaszczanie i przygotowanie ogrodu na zimę.</p>
                </article>
            </div>
        </section>

        <section id="realizacje" class="bg-zinc-900/60 py-20">
            <div class="mx-auto max-w-6xl px-6 lg:px-8">
                <h2 class="text-3xl font-semibold sm:text-4xl">Przykładowe realizacje</h2>
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    <div class="h-64 rounded-2xl bg-gradient-to-br from-lime-700 to-emerald-900 p-5">
                        <p class="text-sm text-lime-100">Ogród nowoczesny — 280 m²</p>
                    </div>
                    <div class="h-64 rounded-2xl bg-gradient-to-br from-emerald-700 to-green-950 p-5">
                        <p class="text-sm text-lime-100">Strefa relaksu z pergolą</p>
                    </div>
                    <div class="h-64 rounded-2xl bg-gradient-to-br from-green-700 to-lime-950 p-5">
                        <p class="text-sm text-lime-100">Ogródek miejski przy szeregowcu</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="kontakt" class="mx-auto max-w-6xl px-6 py-20 lg:px-8">
            <div class="rounded-3xl border border-lime-300/20 bg-lime-300/5 p-8 sm:p-12">
                <h2 class="text-3xl font-semibold sm:text-4xl">Zacznijmy Twój ogród</h2>
                <p class="mt-4 max-w-2xl text-zinc-300">Napisz do nas i otrzymaj darmową konsultację z orientacyjną wyceną w 24h.</p>
                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    <a href="mailto:kontakt@ogrodflow.pl" class="rounded-xl bg-lime-400 px-5 py-3 text-center text-sm font-semibold text-zinc-900 hover:bg-lime-300">kontakt@ogrodflow.pl</a>
                    <a href="tel:+48123456789" class="rounded-xl border border-zinc-300/30 px-5 py-3 text-center text-sm font-semibold hover:border-lime-300 hover:text-lime-300">+48 123 456 789</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
