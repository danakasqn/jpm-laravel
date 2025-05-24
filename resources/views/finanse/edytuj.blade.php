
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">✏️ Edytuj wpis finansowy</h3>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('finanse.aktualizuj', $rekord->id) }}">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Data</label>
                        <input type="date" name="data" class="form-control" value="{{ old('data', $rekord->data) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select" id="apartmentSelect" required>
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}"
                                    data-wynajmujacy="{{ $apartment->residents->last()?->wynajmujacy }}"
                                    {{ $rekord->apartment_id == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Typ</label>
                        <select name="typ" id="typ-operacji" class="form-select" required>
                            @php $typy = ['Przychód', 'Wydatek']; @endphp
                            @foreach($typy as $typ)
                                <option value="{{ $typ }}" {{ $rekord->typ == $typ ? 'selected' : '' }}>{{ $typ }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kwota</label>
                        <input type="number" step="0.01" name="kwota" class="form-control" value="{{ old('kwota', $rekord->kwota) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kategoria</label>
                        <select name="expense_type_id" id="kategoria-operacji" class="form-select" required>
                            <option value="">Najpierw wybierz typ</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Notatka</label>
                        <input type="text" name="notatka" class="form-control" value="{{ old('notatka', $rekord->notatka) }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Wynajmujący</label>
                        <input type="text" id="wynajmujacyInput" class="form-control bg-light" readonly value="{{ $rekord->apartment->residents->last()?->wynajmujacy }}">
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4">💾 Zapisz zmiany</button>
                    <a href="{{ route('finanse.formularz') }}" class="btn btn-outline-secondary ms-2">↩️ Wróć</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typSelect = document.getElementById('typ-operacji');
    const kategoriaSelect = document.getElementById('kategoria-operacji');
    const aktualnaKategoria = @json(old('expense_type_id', $rekord->expense_type_id));
    const mieszkanieSelect = document.getElementById('apartmentSelect');
    const wynajmujacyInput = document.getElementById('wynajmujacyInput');

    function zaladujKategorie() {
        const typ = typSelect.value;
        if (!typ) {
            kategoriaSelect.innerHTML = '<option value="">Najpierw wybierz typ</option>';
            return;
        }

        kategoriaSelect.innerHTML = '<option value="">Ładowanie...</option>';
        fetch(`/api/finanse/kategorie/${encodeURIComponent(typ)}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Wybierz kategorię --</option>';
                data.forEach(k => {
                    const value = typeof k === 'string' ? k : k.value;
                    const label = typeof k === 'string' ? k : k.label;
                    const selected = value == aktualnaKategoria ? 'selected' : '';
                    options += `<option value="${value}" ${selected}>${label}</option>`;
                });
                kategoriaSelect.innerHTML = options;
            })
            .catch(() => {
                kategoriaSelect.innerHTML = '<option>Błąd ładowania kategorii</option>';
            });
    }

    if (typSelect) {
        typSelect.addEventListener('change', zaladujKategorie);
        if (typSelect.value) zaladujKategorie();
    }

    if (mieszkanieSelect && wynajmujacyInput) {
        mieszkanieSelect.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            wynajmujacyInput.value = selected.dataset.wynajmujacy || '';
        });
    }
});
</script>
@endpush
@endsection
