@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">🔁 Finanse cykliczne</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formularz dodawania --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj cykliczny wpis</div>
        <div class="card-body">
            <form action="{{ route('cyclic-finances.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Tytuł</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Np. Urząd Skarbowy" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Typ</label>
                        <select name="type" class="form-select" required>
                            <option value="">-- wybierz --</option>
                            <option value="income" {{ old('type') === 'income' ? 'selected' : '' }}>Przychód</option>
                            <option value="expense" {{ old('type') === 'expense' ? 'selected' : '' }}>Wydatek</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Dzień miesiąca</label>
                        <input type="number" name="due_day" value="{{ old('due_day') }}" class="form-control" min="1" max="31" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select">
                            <option value="">Bez przypisania</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ old('apartment_id') == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->miasto }}, {{ $apartment->ulica }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary w-100">💾 Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela cyklicznych wpisów --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Lista zapisanych wpisów</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center m-0">
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
                                <td>
                                    <span class="badge bg-{{ $cf->type === 'income' ? 'success' : 'danger' }}">
                                        {{ $cf->type === 'income' ? 'Przychód' : 'Wydatek' }}
                                    </span>
                                </td>
                                <td>{{ $cf->due_day }}</td>
                                <td>{{ $cf->apartment->miasto ?? '-' }}, {{ $cf->apartment->ulica ?? '' }}</td>
                                <td>
                                    <a href="{{ route('cyclic-finances.edit', $cf) }}" class="btn btn-sm btn-outline-primary" title="Edytuj">✏️</a>
                                    <form action="{{ route('cyclic-finances.destroy', $cf) }}" method="POST" class="d-inline" onsubmit="return confirm('Usunąć wpis?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Usuń">🗑️</button>
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
</div>
@endsection
