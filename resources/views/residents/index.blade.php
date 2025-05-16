@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 h4 fw-bold">Najemcy</h2>

    @if(session('sukces'))
        <div class="alert alert-success">{{ session('sukces') }}</div>
    @endif

{{-- FORMULARZ --}}
<div class="card mb-4">
    <div class="card-body px-2 py-3">
        <form method="POST" action="{{ route('residents.store') }}">
            @csrf

            {{-- Wiersz 1: Mieszkanie + Imię i nazwisko --}}
            <div class="row g-3">
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

                <div class="col-md-4">
                    <label class="form-label">Imię i nazwisko</label>
                    <input type="text" name="imie_nazwisko" class="form-control" required>
                </div>
            </div>

            {{-- Wiersz 2: Od + Do --}}
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label">Od</label>
                    <input type="date" name="od_kiedy" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Do (opcjonalnie)</label>
                    <input type="date" name="do_kiedy" class="form-control">
                </div>
            </div>
            <div class="form-text mt-1 ms-1">
                Brak daty końcowej oznacza umowę na czas nieokreślony.
            </div>

            {{-- Wiersz 3: Komentarz --}}
            <div class="row g-3 mt-2">
                <div class="col-md-8">
                    <label class="form-label">Komentarz</label>
                    <textarea name="komentarz" class="form-control"
                              rows="2"
                              oninput="this.style.height='';this.style.height=this.scrollHeight + 'px'"></textarea>
                </div>
            </div>

            {{-- Przycisk na dole, wyśrodkowany --}}
            <div class="text-left mt-3">
                <button type="submit" class="btn btn-primary px-4">Dodaj</button>
            </div>
        </form>
    </div>
</div>

    {{-- TABELA --}}
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mieszkanie</th>
                            <th>Imię i nazwisko</th>
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
                                <td>{{ $r->apartment->miasto }}, {{ $r->apartment->ulica }}</td>
                                <td>{{ $r->imie_nazwisko }}</td>
                                <td>{{ $r->od_kiedy }}</td>
                                <td>{{ $r->do_kiedy ?? '—' }}</td>
                                <td class="text-start">{{ $r->komentarz ?? '—' }}</td>
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
                                    <a href="{{ route('residents.edit', $r->id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('residents.destroy', $r->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Usunąć najemcę?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">Brak najemców.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
