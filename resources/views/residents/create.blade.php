@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">👤 Dodaj najemcę</h3>

    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body">
            <form method="POST" action="{{ route('residents.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Imię i nazwisko</label>
                    <input type="text" name="imie_nazwisko" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mieszkanie</label>
                    <select name="apartment_id" class="form-select" required>
                        @foreach($mieszkania as $mieszkanie)
                            <option value="{{ $mieszkanie->id }}">
                                {{ $mieszkanie->miasto }} - {{ $mieszkanie->ulica }} ({{ $mieszkanie->metraz }} m²)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Data rozpoczęcia</label>
                        <input type="date" name="od_kiedy" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Data zakończenia (opcjonalnie)</label>
                        <input type="date" name="do_kiedy" class="form-control">
                        <small class="text-muted">Pozostaw puste dla umowy na czas nieokreślony</small>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Komentarz</label>
                    <textarea name="komentarz" class="form-control" rows="3" style="resize: vertical;"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        💾 Zapisz najemcę
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
