@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">📄 Rozliczenie podatku - Urząd Skarbowy</h4>

    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-4">
            <label class="form-label">Wynajmujący (imię i nazwisko)</label>
            <input type="text" name="wynajmujacy" class="form-control" value="{{ request('wynajmujacy') }}" placeholder="np. Jan Kowalski">
        </div>
        <div class="col-md-2">
            <label class="form-label">Rok</label>
            <select name="rok" class="form-select">
                @for($year = now()->year; $year >= now()->year - 5; $year--)
                    <option value="{{ $year }}" {{ request('rok', now()->year) == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Miesiąc</label>
            <select name="miesiac" class="form-select">
                @foreach(['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'] as $index => $name)
                    <option value="{{ $index + 1 }}" {{ request('miesiac', now()->subMonth()->month) == ($index + 1) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 text-end">
            <button type="submit" class="btn btn-primary">🔍 Filtruj</button>
            <a href="{{ route('cyclic-finances.urzad-skarbowy') }}" class="btn btn-outline-secondary ms-2">Wyczyść</a>
        </div>
    </form>

    @forelse($all as $landlord => $dane)
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">👤 {{ $landlord }}</h5>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-bordered table-striped mb-0 text-center align-middle">
    <thead class="table-light">
        <tr>
            <th>Lokal</th>
            <th>Udział %</th>
            <th>Przychód</th>
            <th>8.5%</th>
            <th>12.5%</th>
            <th>Podatek</th>
        </tr>
    </thead>
    <tbody>
        @foreach($dane['mieszkania'] as $m)
            <tr>
                <td>{{ $m['adres'] }}</td>
                <td>{{ $m['procent'] }}%</td>
                <td>{{ number_format($m['suma'], 2) }} zł</td>
                <td>{{ number_format($m['czesc_85'], 2) }} zł</td>
                <td>{{ number_format($m['czesc_125'], 2) }} zł</td>
                <td class="fw-bold text-danger">{{ number_format($m['podatek'], 2) }} zł</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot class="table-light">
        <tr>
            <th colspan="5" class="text-end">Suma podatku:</th>
            <th class="fw-bold text-success">{{ number_format($dane['info']['podatek'], 2) }} zł</th>
        </tr>
    </tfoot>
</table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">Brak danych do wyświetlenia dla wybranych filtrów.</div>
    @endforelse
</div>
@endsection
