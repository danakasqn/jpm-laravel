@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">✏️ Edytuj wpis finansowy</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('finanse.aktualizuj', $rekord->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Data</label>
                        <input type="date" name="data" class="form-control" value="{{ old('data', $rekord->data) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select" required>
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ $rekord->apartment_id == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Typ</label>
                        <select name="typ" class="form-select" required>
                            <option value="Przychód" {{ $rekord->typ == 'Przychód' ? 'selected' : '' }}>Przychód</option>
                            <option value="Wydatek" {{ $rekord->typ == 'Wydatek' ? 'selected' : '' }}>Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kwota</label>
                        <input type="number" step="0.01" name="kwota" class="form-control" value="{{ old('kwota', $rekord->kwota) }}" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kategoria</label>
                        <select name="kategoria" class="form-select">
                            <option value="">Wybierz kategorię</option>
                            @php
                                $kategorie = ['Czynsz najmu', 'Czynsz administracyjny', 'Prąd', 'Urząd Skarbowy', 'Inne'];
                            @endphp
                            @foreach($kategorie as $kat)
                                <option value="{{ $kat }}" {{ old('kategoria', $rekord->kategoria) == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Notatka</label>
                        <input type="text" name="notatka" class="form-control" value="{{ old('notatka', $rekord->notatka) }}">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">💾 Zapisz zmiany</button>
                    <a href="{{ route('finanse.index') }}" class="btn btn-outline-secondary ms-2">↩️ Wróć</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
