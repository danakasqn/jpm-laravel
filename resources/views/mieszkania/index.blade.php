@extends('layouts.app')

@section('content')
<div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">

    <h2 class="mb-4 fs-4 fw-semibold">Lista lokali</h2>

    @if(session('sukces'))
        <div class="alert alert-success mb-4">{{ session('sukces') }}</div>
    @endif

    {{-- FORMULARZ DODAWANIA --}}
    <div class="bg-white shadow-sm rounded p-4 mb-4">
        <form method="POST" action="{{ route('mieszkania.zapisz') }}">
            @csrf
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <input type="text" name="miasto" class="form-control" placeholder="Miasto" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="ulica" class="form-control" placeholder="Ulica i nr" required>
                </div>
                <div class="col-md-1">
                    <input type="text" name="metraz" class="form-control" placeholder="m²" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="wspolnota" class="form-control" placeholder="Wspólnota" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="telefon" class="form-control" placeholder="Tel. wspólnoty">
                </div>
                <div class="col-md-3">
                    <input type="email" name="email" class="form-control" placeholder="Email wspólnoty">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Komentarz</label>
                <textarea name="notatka" class="form-control" placeholder="Komentarz" rows="3" style="resize: vertical;"></textarea>
            </div>

            <div class="mt-3 d-grid">
                <button type="submit" class="btn btn-primary">Dodaj</button>
            </div>
        </form>
    </div>

    {{-- TABELA MIESZKAŃ --}}
    <div class="bg-white shadow-sm rounded p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Miasto</th>
                        <th>Ulica</th>
                        <th>Metraż</th>
                        <th>Wspólnota</th>
                        <th>Telefon</th>
                        <th>Email</th>
                        <th>Komentarz</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mieszkania as $m)
                        <tr>
                            <td style="white-space: nowrap;">{{ $m->miasto }}</td>
                            <td style="white-space: nowrap;">{{ $m->ulica }}</td>
                            <td style="white-space: nowrap;">{{ $m->metraz }} m²</td>
                            <td style="white-space: nowrap;">{{ $m->wspolnota }}</td>
                            <td style="white-space: nowrap;">{{ $m->telefon }}</td>
                            <td style="white-space: nowrap;">{{ $m->email }}</td>
                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $m->notatka }}">
                                {{ $m->notatka }}
                            </td>
                            <td>
                                <a href="{{ route('mieszkania.edytuj', $m->id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('mieszkania.usun', $m->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Usunąć lokal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">Brak lokali</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
