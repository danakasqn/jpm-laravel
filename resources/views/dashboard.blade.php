@extends('layouts.app')

@section('content')
<div class="container-fluid">

    {{-- === SEKCJA 1: Kafelki === --}}
    <h5 class="mb-3 text-uppercase text-muted fw-bold">📊 Finanse – bieżący miesiąc</h5>
    <div class="row g-4 mb-5">
        {{-- Przychody --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
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
                    <small class="text-success fw-semibold d-block mt-2">+{{ rand(3,8) }}% względem zeszłego miesiąca</small>
                </div>
            </div>
        </div>

        {{-- Wydatki --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
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
                    <small class="text-danger fw-semibold d-block mt-2">-{{ rand(4,10) }}% względem zeszłego miesiąca</small>
                </div>
            </div>
        </div>

        {{-- Dochód --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
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
                        {{ $monthlyProfit >= 0 ? '+' : '' }}{{ rand(1,5) }}% względem zeszłego miesiąca
                    </small>
                </div>
            </div>
        </div>

        {{-- Najemcy --}}
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
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

    {{-- === SEKCJE RÓWNOLEGŁE: Płatności | Umowy === --}}
    <div class="row g-4">
        {{-- Zaległe płatności cykliczne --}}
        <div class="col-md-6">
            <h6 class="text-muted text-uppercase fw-bold mb-3">
                <i class="bi bi-arrow-repeat me-2 text-primary"></i>
                Zaległe operacje cykliczne
            </h6>

            @if($missingCyclicFinances->isEmpty())
                <div class="alert alert-success">Brak zaległych cyklicznych operacji.</div>
            @else
                @foreach($missingCyclicFinances as $item)
                    <div class="bg-white border rounded shadow-sm p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="mb-1">
                                    <span class="text-warning">💡</span>
                                    <strong>{{ $item['cyclic']->title }}</strong>
                                    ({{ $item['cyclic']->type === 'income' ? 'Przychód' : 'Wydatek' }})
                                </div>
                                <div>
                                    Miesiąc: <strong>{{ $item['month']->format('m.Y') }}</strong><br>
                                    Lokal: <span class="fw-semibold text-dark">
                                        {{ $item['cyclic']->apartment->miasto ?? '-' }},
                                        {{ $item['cyclic']->apartment->ulica ?? '' }}
                                    </span><br>
                                    Termin: <strong>
                                        {{ str_pad($item['cyclic']->due_day, 2, '0', STR_PAD_LEFT) }}.{{ $item['month']->format('m.Y') }}
                                    </strong>
                                </div>
                            </div>
                            <a href="{{ route('finanse.index') }}" class="btn btn-sm btn-outline-warning">
                                ➕ Dodaj płatność
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
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
@endsection