@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">✏️ Edytuj najemcę</h3>

    <div class="card shadow-sm mx-auto" style="max-width: 700px;">
        <div class="card-body">
            <form method="POST" action="{{ route('residents.update', $resident->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Imię i nazwisko</label>
                    <input type="text" name="imie_nazwisko" value="{{ $resident->imie_nazwisko }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mieszkanie</label>
                    <select name="apartment_id" class="form-select" required>
                        @foreach($mieszkania as $mieszkanie)
                            <option value="{{ $mieszkanie->id }}" @if($resident->apartment_id == $mieszkanie->id) selected @endif>
                                {{ $mieszkanie->miasto }}, {{ $mieszkanie->ulica }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3 g-3">
                    <div class="col-md-6">
                        <label class="form-label">Data rozpoczęcia</label>
                        <input type="date" name="od_kiedy" value="{{ $resident->od_kiedy }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Data zakończenia</label>
                        <input type="date" name="do_kiedy" value="{{ $resident->do_kiedy }}" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Komentarz</label>
                    <textarea name="komentarz" class="form-control" rows="3" style="resize: vertical;">{{ old('komentarz', $resident->komentarz) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">💾 Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
