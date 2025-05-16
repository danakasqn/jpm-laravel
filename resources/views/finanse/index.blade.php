@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 h4 fw-bold">Finanse</h2>

    @if(session('sukces'))
        <div class="alert alert-success">{{ session('sukces') }}</div>
    @endif

    {{-- FORMULARZ ZAPISU --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">➕ Dodaj wpis</div>
        <div class="card-body">
            <form method="POST" action="{{ route('finanse.zapisz') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <select name="apartment_id" class="form-select" required>
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}">{{ $apartment->adres }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <select name="typ" class="form-select" required>
                            <option value="Przychód">Przychód</option>
                            <option value="Wydatek">Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <select name="kategoria" class="form-select">
                            <option value="">Wybierz kategorię</option>
                            <option value="Czynsz najmu">Czynsz najmu</option>
                            <option value="Czynsz administracyjny">Czynsz administracyjny</option>
                            <option value="Prąd">Prąd</option>
                            <option value="Urząd Skarbowy">Urząd Skarbowy</option>
                            <option value="Inne">Inne</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <input type="number" step="0.01" name="kwota" class="form-control" placeholder="Kwota [zł]" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="notatka" class="form-control" placeholder="Notatka">
                    </div>

                    <div class="col-12 mt-3 mb-4">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- FORMULARZ FILTROWANIA --}}
    <div class="card mb-4">
        <div class="card-header fw-bold">🔍 Filtruj wpisy</div>
        <div class="card-body">
            <form method="GET" action="{{ route('finanse.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select name="apartment_id" class="form-select">
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ request('apartment_id') == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="typ" class="form-select">
                            <option value="">Typ</option>
                            <option value="Przychód" {{ request('typ') == 'Przychód' ? 'selected' : '' }}>Przychód</option>
                            <option value="Wydatek" {{ request('typ') == 'Wydatek' ? 'selected' : '' }}>Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="kategoria" class="form-select">
                            <option value="">Kategoria</option>
                            <option value="Czynsz najmu" {{ request('kategoria') == 'Czynsz najmu' ? 'selected' : '' }}>Czynsz najmu</option>
                            <option value="Czynsz administracyjny" {{ request('kategoria') == 'Czynsz administracyjny' ? 'selected' : '' }}>Czynsz administracyjny</option>
                            <option value="Prąd" {{ request('kategoria') == 'Prąd' ? 'selected' : '' }}>Prąd</option>
                            <option value="Urząd Skarbowy" {{ request('kategoria') == 'Urząd Skarbowy' ? 'selected' : '' }}>Urząd Skarbowy</option>
                            <option value="Inne" {{ request('kategoria') == 'Inne' ? 'selected' : '' }}>Inne</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="data_od" class="form-control" placeholder="Od" value="{{ request('data_od') }}">
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="data_do" class="form-control" placeholder="Do" value="{{ request('data_do') }}">
                    </div>

                    <div class="col-md-12 d-flex gap-2">
                        <button type="submit" class="btn btn-secondary">Filtruj</button>
                        <a href="{{ route('finanse.index') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABELA --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Mieszkanie</th>
                            <th>Typ</th>
                            <th>Kwota</th>
                            <th>Kategoria</th>
                            <th>Notatka</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finanse as $rekord)
                            <tr>
                                <td>{{ $rekord->data }}</td>
                                <td>{{ $rekord->apartment->adres ?? 'Brak danych' }}</td>
                                <td>
                                    <span class="badge {{ $rekord->typ == 'Przychód' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $rekord->typ }}
                                    </span>
                                </td>
                                <td>{{ number_format($rekord->kwota, 2) }} zł</td>
                                <td>{{ $rekord->kategoria }}</td>
                                <td>{{ $rekord->notatka }}</td>
                                <td>
                                    <a href="{{ route('finanse.edytuj', $rekord->id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('finanse.usun', $rekord->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć ten rekord?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Brak danych.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BILANS --}}
    <div class="alert alert-info text-center fw-bold mt-4">
        💰 Suma przychodów: {{ number_format($sumaPrzychodow, 2) }} zł &nbsp;&nbsp;
        🟢 Suma wydatków: {{ number_format($sumaWydatkow, 2) }} zł &nbsp;&nbsp;
        📊 Bilans: {{ number_format($bilans, 2) }} zł
    </div>

</div>
@endsection
