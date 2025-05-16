@extends('layouts.app')

@section('content')
<div class="py-4 max-w-7xl mx-auto sm:px-6 lg:px-8">

    <h2 class="mb-4 fs-4 fw-semibold">Finanse cykliczne</h2>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARZ DODAWANIA --}}
    <div class="bg-white shadow-sm rounded p-4 mb-4">
        <form action="{{ route('cyclic-finances.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Tytuł (np. Urząd Skarbowy)" required>
                </div>
                <div class="col-md-2">
                    <select name="type" class="form-select" required>
                        <option value="">Typ</option>
                        <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Przychód</option>
                        <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Wydatek</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="due_day" value="{{ old('due_day') }}" class="form-control" placeholder="Dzień miesiąca" required min="1" max="31">
                </div>
                <div class="col-md-3">
                    <select name="apartment_id" class="form-select">
                        <option value="">Bez mieszkania</option>
                        @foreach($apartments as $apartment)
                            <option value="{{ $apartment->id }}" {{ old('apartment_id') == $apartment->id ? 'selected' : '' }}>
                                {{ $apartment->miasto }}, {{ $apartment->ulica }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABELA --}}
    <div class="bg-white shadow-sm rounded p-4">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Tytuł</th>
                        <th>Typ</th>
                        <th>Dzień</th>
                        <th>Mieszkanie</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cyclicFinances as $cf)
                        <tr>
                            <td>{{ $cf->title }}</td>
                            <td>{{ $cf->type === 'income' ? 'Przychód' : 'Wydatek' }}</td>
                            <td>{{ $cf->due_day }}</td>
                            <td>
                                {{ $cf->apartment->miasto ?? '-' }}, {{ $cf->apartment->ulica ?? '' }}
                            </td>
                            <td>
                                <a href="{{ route('cyclic-finances.edit', $cf) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                <form action="{{ route('cyclic-finances.destroy', $cf) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Usunąć wpis?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Brak danych</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
