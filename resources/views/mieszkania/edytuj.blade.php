@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">✏️ Edytuj lokal</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('mieszkania.aktualizuj', $mieszkanie->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Miasto</label>
                        <input type="text" name="miasto" value="{{ old('miasto', $mieszkanie->miasto) }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ulica i nr</label>
                        <input type="text" name="ulica" value="{{ old('ulica', $mieszkanie->ulica) }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Metraż (m²)</label>
                        <input type="text" name="metraz" value="{{ old('metraz', $mieszkanie->metraz) }}" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Wspólnota</label>
                        <input type="text" name="wspolnota" value="{{ old('wspolnota', $mieszkanie->wspolnota) }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Telefon</label>
                        <input type="text" name="telefon" value="{{ old('telefon', $mieszkanie->telefon) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $mieszkanie->email) }}" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Komentarz</label>
                        <textarea name="notatka" class="form-control" rows="4">{{ old('notatka', $mieszkanie->notatka) }}</textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('mieszkania.index') }}" class="btn btn-outline-secondary me-2">← Wróć</a>
                    <button type="submit" class="btn btn-success">💾 Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
