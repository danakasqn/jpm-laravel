@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">⚙️ Typy operacji finansowych</h3>

    {{-- Alerty --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formularz --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj kategorię operacji</div>
        <div class="card-body">
            <form action="{{ route('settings.expense-types.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Typ operacji</label>
                        <select name="name" class="form-select" required>
                            <option value="">-- Wybierz typ --</option>
                            <option value="Przychód">Przychód</option>
                            <option value="Wydatek">Wydatek</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategoria</label>
                        <input type="text" name="category" class="form-control" placeholder="np. Czynsz najmu, Media, Prąd" required>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="submit" class="btn btn-primary w-100">➕ Dodaj</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Zdefiniowane typy operacji</div>
        <div class="card-body table-responsive p-0">
            <table class="table table-striped align-middle text-center m-0">
                <thead class="table-light">
                    <tr>
                        <th>Typ</th>
                        <th>Kategoria</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                        <tr>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->category }}</td>
                            <td class="text-center">
                                @if($type->id)
                                    <a href="{{ route('settings.expense-types.edit', ['typy_wydatkow' => $type->id]) }}" class="btn btn-sm btn-outline-primary" title="Edytuj">✏️</a>

                                    <form action="{{ route('settings.expense-types.destroy', ['typy_wydatkow' => $type->id]) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Usunąć kategorię?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Usuń">🗑️</button>
                                    </form>
                                @else
                                    <span class="text-muted">Brak ID</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted">Brak zdefiniowanych typów operacji.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
