@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">📊 Zarządzanie Finansami</h3>

    {{-- Formularz dodawania --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj nowy wpis</div>
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
                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">💾 Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Statystyki --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3 border-start border-success border-4">
                <div class="fw-semibold text-muted">Suma przychodów</div>
                <h4 class="text-success mt-2">{{ number_format($sumaPrzychodow, 2) }} zł</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3 border-start border-danger border-4">
                <div class="fw-semibold text-muted">Suma wydatków</div>
                <h4 class="text-danger mt-2">{{ number_format($sumaWydatkow, 2) }} zł</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3 border-start border-primary border-4">
                <div class="fw-semibold text-muted">Bilans</div>
                <h4 class="text-primary mt-2">{{ number_format($bilans, 2) }} zł</h4>
            </div>
        </div>
    </div>

    {{-- Tabela wpisów --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Historia wpisów</div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover align-middle text-center mb-0">
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
                                <a href="{{ route('finanse.edytuj', $rekord->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edytuj">✏️</a>
                                <form action="{{ route('finanse.usun', $rekord->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Usunąć wpis?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Usuń">🗑️</button>
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
    </div>
</div>
@endsection
