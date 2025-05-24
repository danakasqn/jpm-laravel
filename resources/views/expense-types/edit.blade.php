@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">✏️ Edytuj typ operacji</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.expense-types.update', $expenseType) }}" method="POST" class="card shadow-sm p-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Rodzaj</label>
            <select name="name" class="form-select" required>
                <option value="Przychód" {{ old('name', $expenseType->name) === 'Przychód' ? 'selected' : '' }}>Przychód</option>
                <option value="Wydatek" {{ old('name', $expenseType->name) === 'Wydatek' ? 'selected' : '' }}>Wydatek</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategoria</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $expenseType->category) }}" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="taxable" value="1" class="form-check-input" id="taxableCheck"
                {{ old('taxable', $expenseType->taxable) ? 'checked' : '' }}>
            <label class="form-check-label" for="taxableCheck">Wliczaj do podatku</label>
        </div>

        <div class="text-end">
            <a href="{{ route('settings.expense-types.index') }}" class="btn btn-outline-secondary">← Wróć</a>
            <button type="submit" class="btn btn-primary">💾 Zapisz</button>
        </div>
    </form>
</div>
@endsection