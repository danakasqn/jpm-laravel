@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">✏️ Edytuj cykliczny wpis</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm mx-auto" style="max-width: 800px;">
        <div class="card-body">
            <form action="{{ route('cyclic-finances.update', $cyclicFinance) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tytuł</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $cyclicFinance->title) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Typ</label>
                        <select name="type" class="form-select" required>
                            <option value="income" {{ old('type', $cyclicFinance->type) === 'income' ? 'selected' : '' }}>Przychód</option>
                            <option value="expense" {{ old('type', $cyclicFinance->type) === 'expense' ? 'selected' : '' }}>Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Dzień miesiąca</label>
                        <input type="number" name="due_day" class="form-control" value="{{ old('due_day', $cyclicFinance->due_day) }}" min="1" max="31" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select">
                            <option value="">Bez mieszkania</option>
                            @foreach ($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ old('apartment_id', $cyclicFinance->apartment_id) == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->miasto }}, {{ $apartment->ulica }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <a href="{{ route('cyclic-finances.index') }}" class="btn btn-outline-secondary me-2">← Wróć</a>
                    <button type="submit" class="btn btn-success">💾 Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
