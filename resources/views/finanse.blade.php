@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Finanse</h2>

    {{-- FORMULARZ DODAWANIA --}}
    <div class="card mb-4">
        <div class="card-header">Dodaj wpis</div>
        <div class="card-body">
            <form method="POST" action="{{ route('finanse.zapisz') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="date" name="data" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="mieszkanie" class="form-control" placeholder="Mieszkanie" required>
                    </div>
                    <div class="col-md-2">
                        <select name="typ" class="form-select" required>
                            <option value="Przychód">Przychód</option>
                            <option value="Wydatek">Wydatek</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="kwota" step="0.01" class="form-control" placeholder="Kwota" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="kategoria" class="form-control" placeholder="Kategoria">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="notatka" class="form-control" placeholder="Notatka">
                    </div>
                    <div class="col-md-12 d-grid mt-3">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABELA --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
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
                        <td>{{ $rekord->mieszkanie }}</td>
                        <td>
                            <span class="badge bg-{{ $rekord->typ == 'Przychód' ? 'success' : 'danger' }}">
                                {{ $rekord->typ }}
                            </span>
                        </td>
                        <td>{{ number_format($rekord->kwota, 2) }} zł</td>
                        <td>{{ $rekord->kategoria }}</td>
                        <td>{{ $rekord->notatka }}</td>
                        <td>
                            <a href="{{ route('finanse.edytuj', $rekord->id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                            <form action="{{ route('finanse.usun', $rekord->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Usunąć wpis?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-muted">Brak danych</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- BILANS --}}
    <div class="alert alert-info mt-4">
        <strong>💰 Suma przychodów:</strong> {{ number_format($sumaPrzychodow, 2) }} zł <br>
        <strong>💸 Suma wydatków:</strong> {{ number_format($sumaWydatkow, 2) }} zł <br>
        <strong>📊 Bilans:</strong> {{ number_format($bilans, 2) }} zł
    </div>
</div>
@endsection
