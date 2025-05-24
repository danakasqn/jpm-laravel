@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">🏢 Lista lokali</h3>

    @if(session('sukces'))
        <div class="alert alert-success">{{ session('sukces') }}</div>
    @endif

    {{-- Formularz dodawania --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj nowy lokal</div>
        <div class="card-body">
            <form method="POST" action="{{ route('mieszkania.zapisz') }}">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Właściciel</label>
                        <input type="text" name="wlasciciel" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Miasto</label>
                        <input type="text" name="miasto" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ulica i nr</label>
                        <input type="text" name="ulica" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Metraż (m²)</label>
                        <input type="text" name="metraz" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Wspólnota</label>
                        <input type="text" name="wspolnota" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Telefon</label>
                        <input type="text" name="telefon" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Komentarz</label>
                    <textarea name="notatka" class="form-control" rows="3" placeholder="Opcjonalny komentarz"></textarea>
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-primary">➕ Dodaj lokal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela mieszkań --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Zarejestrowane lokale</div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped align-middle text-center m-0">
                <thead class="table-light">
                    <tr>
                        <th>Właściciel</th>
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
                            <td>{{ $m->wlasciciel }}</td>
                            <td>{{ $m->miasto }}</td>
                            <td>{{ $m->ulica }}</td>
                            <td>{{ $m->metraz }} m²</td>
                            <td>{{ $m->wspolnota }}</td>
                            <td>{{ $m->telefon }}</td>
                            <td>{{ $m->email }}</td>
                            <td>
                                <span title="{{ $m->notatka }}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: inline-block; max-width: 200px;">
                                    {{ $m->notatka }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('mieszkania.edytuj', $m->id) }}" class="btn btn-sm btn-outline-primary" title="Edytuj">✏️</a>
                                <form action="{{ route('mieszkania.usun', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Usunąć lokal?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Usuń">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-muted">Brak lokali</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
