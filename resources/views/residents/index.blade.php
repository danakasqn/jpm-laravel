@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">👥 Najemcy</h3>

    @if(session('sukces'))
        <div class="alert alert-success">{{ session('sukces') }}</div>
    @endif

    {{-- Formularz dodawania --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj nowego najemcę</div>
        <div class="card-body">
            <form method="POST" action="{{ route('residents.store') }}">
                @csrf

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Wynajmujący</label>
                        <input type="text" name="wynajmujacy" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Najemca</label>
                        <input type="text" name="imie_nazwisko" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select" required>
                            @foreach($mieszkania as $mieszkanie)
                                <option value="{{ $mieszkanie->id }}">
                                    {{ $mieszkanie->miasto }}, {{ $mieszkanie->ulica }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Od</label>
                        <input type="date" name="od_kiedy" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Do</label>
                        <input type="date" name="do_kiedy" class="form-control">
                        <small class="text-muted">Brak = czas nieokreślony</small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Komentarz</label>
                        <textarea name="komentarz" class="form-control" rows="2" style="resize: vertical;"></textarea>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary">➕ Dodaj</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela najemców --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Lista najemców</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Wynajmujący</th>
                            <th>Najemca</th>
                            <th>Lokal</th>
                            <th>Od</th>
                            <th>Do</th>
                            <th>Komentarz</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($residents as $r)
                            <tr>
                                <td>{{ $r->wynajmujacy ?? '—' }}</td>
                                <td>{{ $r->imie_nazwisko }}</td>
                                <td>{{ $r->apartment->miasto }}, {{ $r->apartment->ulica }}</td>
                                <td>{{ $r->od_kiedy }}</td>
                                <td>{{ $r->do_kiedy ?? '—' }}</td>
                                <td class="text-start">
                                    <span title="{{ $r->komentarz }}">
                                        {{ \Str::limit($r->komentarz, 60) ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $dniDoKonca = $r->do_kiedy ? now()->diffInDays(\Carbon\Carbon::parse($r->do_kiedy), false) : null;
                                    @endphp

                                    @if(is_null($dniDoKonca))
                                        <span class="badge bg-success">Aktywna</span>
                                    @elseif($dniDoKonca < 0)
                                        <span class="badge bg-danger">Wygasła</span>
                                    @elseif($dniDoKonca <= 14)
                                        <span class="badge bg-warning text-dark">Kończy się</span>
                                    @else
                                        <span class="badge bg-success">Aktywna</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('residents.edit', $r->id) }}" class="btn btn-sm btn-outline-primary" title="Edytuj">✏️</a>
                                    <form action="{{ route('residents.destroy', $r->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Usunąć najemcę?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Usuń">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Brak najemców.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
