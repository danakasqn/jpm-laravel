@extends('layouts.app')

@section('content')
<div class="py-4 max-w-4xl mx-auto sm:px-6 lg:px-8">
    <h2 class="mb-4 fs-4 fw-semibold">Edycja wpisu cyklicznego</h2>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-sm rounded p-4">
        <form action="{{ route('cyclic-finances.update', $cyclicFinance) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" value="{{ old('title', $cyclicFinance->title) }}" placeholder="Tytuł" required>
                </div>

                <div class="col-md-3">
                    <select name="type" class="form-select" required>
                        <option value="income" {{ old('type', $cyclicFinance->type) === 'income' ? 'selected' : '' }}>Przychód</option>
                        <option value="expense" {{ old('type', $cyclicFinance->type) === 'expense' ? 'selected' : '' }}>Wydatek</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="number" name="due_day" class="form-control" value="{{ old('due_day', $cyclicFinance->due_day) }}" min="1" max="31" required>
                </div>

                <div class="col-md-3">
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

            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('cyclic-finances.index') }}" class="btn btn-secondary">⟵ Wróć</a>
                <button type="submit" class="btn btn-success">Zapisz zmiany</button>
            </div>
        </form>
    </div>
</div>
@endsection
