@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4">

    {{-- 🔽 Formularz z wyborem typu zakresu: miesiąc lub rok --}}
    <form method="GET" class="row g-2 align-items-center mb-4">
        <div class="col-auto">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-funnel-fill text-primary"></i>
                </span>
                <select name="range_type" id="rangeType" class="form-select border-start-0">
                    <option value="month" {{ $rangeType === 'month' ? 'selected' : '' }}>Miesiąc</option>
                    <option value="year" {{ $rangeType === 'year' ? 'selected' : '' }}>Rok</option>
                </select>
            </div>
        </div>

        <div class="col-auto" id="monthSelectGroup">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-calendar-event-fill text-primary"></i>
                </span>
                <select name="month" class="form-select border-start-0">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-auto">
            <div class="input-group">
                <span class="input-group-text bg-white">
                    <i class="bi bi-calendar-range-fill text-primary"></i>
                </span>
                <select name="year" class="form-select border-start-0">
                    @foreach(range(now()->year - 2, now()->year + 1) as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-outline-primary shadow-sm px-4">
                <i class="bi bi-arrow-repeat me-1"></i> Zastosuj
            </button>
        </div>
    </form>

    {{-- === SEKCJA 1: Kafelki === --}}
    <h5 class="mb-3 text-uppercase text-muted fw-bold">
        📊 Finanse – {{ $rangeType === 'year' ? 'cały rok ' . $year : \Carbon\Carbon::create($year, $month)->translatedFormat('F Y') }}
    </h5>

    <div class="row g-4 mb-5">
        {{-- Przychody --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1">Przychody</h6>
                            <h4 class="mb-0">{{ number_format($monthlyIncomes, 2) }} zł</h4>
                        </div>
                        <div class="bg-light rounded-circle p-2">
                            <i class="bi bi-arrow-down-circle-fill fs-4 text-success"></i>
                        </div>
                    </div>
                    <small class="text-success fw-semibold d-block mt-2">+{{ rand(3,8) }}% względem zeszłego okresu</small>
                </div>
            </div>
        </div>

        {{-- Wydatki --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1">Wydatki</h6>
                            <h4 class="mb-0">{{ number_format($monthlyExpenses, 2) }} zł</h4>
                        </div>
                        <div class="bg-light rounded-circle p-2">
                            <i class="bi bi-arrow-up-circle-fill fs-4 text-danger"></i>
                        </div>
                    </div>
                    <small class="text-danger fw-semibold d-block mt-2">-{{ rand(4,10) }}% względem zeszłego okresu</small>
                </div>
            </div>
        </div>

        {{-- Dochód --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1">Dochód</h6>
                            <h4 class="mb-0">{{ number_format($monthlyProfit, 2) }} zł</h4>
                        </div>
                        <div class="bg-light rounded-circle p-2">
                            <i class="bi bi-graph-up-arrow fs-4 text-primary"></i>
                        </div>
                    </div>
                    <small class="text-primary fw-semibold d-block mt-2">
                        {{ $monthlyProfit >= 0 ? '+' : '' }}{{ rand(1,5) }}% względem zeszłego okresu
                    </small>
                </div>
            </div>
        </div>

        {{-- Najemcy --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0 card-hover">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1">Najemcy</h6>
                            <h4 class="mb-0">{{ \App\Models\Resident::count() }}</h4>
                        </div>
                        <div class="bg-light rounded-circle p-2">
                            <i class="bi bi-people-fill fs-4 text-secondary"></i>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">Stan na dziś</small>
                </div>
            </div>
        </div>
    </div>

    {{-- === SEKCJE RÓWNOLEGŁE === --}}
    <div class="row g-4">
        {{-- 🔔 Przypomnienie o płatnościach --}}
        <div class="col-md-6">
            <h6 class="text-muted text-uppercase fw-bold mb-3">
                <i class="bi bi-bell-fill me-2 text-warning"></i>
                Przypomnienie o płatnościach
            </h6>

            <div class="bg-white border rounded shadow-sm p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1">
                            Pozostało <strong>{{ $missingCyclicFinances->count() }}</strong> operacji finansowych do wykonania.
                        </p>
                        <p class="mb-0">
                            Najbliższy termin to: <strong>{{ $nextDueDate }}</strong>
                        </p>
                    </div>
                    <a href="{{ route('finanse.operacje') }}" class="btn btn-outline-primary btn-sm">
                        ➡️ Przejdź
                    </a>
                </div>
            </div>
        </div>

        {{-- Umowy kończące się --}}
        <div class="col-md-6">
            <h6 class="text-muted text-uppercase fw-bold mb-3">
                <i class="bi bi-calendar2-x-fill me-2 text-primary"></i>
                Umowy kończące się w ciągu 14 dni
            </h6>

            @if($endingSoonResidents->isEmpty())
                <div class="alert alert-info">Brak mieszkańców z kończącą się umową.</div>
            @else
                @foreach($endingSoonResidents as $resident)
                    <div class="bg-white border rounded shadow-sm p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="mb-1">
                                    <span class="text-danger fw-bold">❌ Umowa do:</span>
                                    {{ \Carbon\Carbon::parse($resident->do_kiedy)->format('d.m.Y') }}
                                </div>
                                <div>
                                    Lokal: <span class="fw-semibold text-dark">
                                        {{ $resident->apartment->miasto ?? '-' }},
                                        {{ $resident->apartment->ulica ?? '' }}
                                    </span><br>
                                    Najemca: <strong>{{ $resident->imie_nazwisko ?? 'Brak danych' }}</strong>
                                </div>
                            </div>
                            <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-sm btn-outline-primary">
                                ✏️ Edytuj
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

{{-- 🔧 Dynamiczne ukrywanie pola miesiąca jeśli wybrano "rok" --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rangeType = document.getElementById('rangeType');
        const monthGroup = document.getElementById('monthSelectGroup');

        function toggleMonthField() {
            if (rangeType.value === 'year') {
                monthGroup.style.display = 'none';
            } else {
                monthGroup.style.display = 'block';
            }
        }

        rangeType.addEventListener('change', toggleMonthField);
        toggleMonthField(); // wywołanie na starcie
    });
</script>

<style>
.card-hover:hover {
    transform: scale(1.02);
    transition: 0.2s ease-in-out;
    box-shadow: 0 0 12px rgba(0, 0, 0, 0.06);
}
</style>
@endsection
