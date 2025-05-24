@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 h4 fw-bold">💰 Finanse</h2>

    @if(session('sukces'))
        <div class="alert alert-success">{{ session('sukces') }}</div>
    @endif

    {{-- FORMULARZ ZAPISU --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold">➕ Dodaj wpis</div>
        <div class="card-body">
            <form method="POST" action="{{ route('finanse.zapisz') }}" autocomplete="off">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select" id="apartmentSelect" required>
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option 
                                    value="{{ $apartment->id }}"
                                    data-wynajmujacy="{{ $apartment->residents->last()?->wynajmujacy }}"
                                    {{ (old('apartment_id') ?? ($prefill['apartment_id'] ?? null)) == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Typ</label>
                        <select name="typ" id="typ-operacji" class="form-select" required>
                            <option value="">Wybierz typ</option>
                            @foreach($typyOperacji as $typ)
                                <option value="{{ $typ }}" {{ (old('typ') ?? ($prefill['typ'] ?? null)) == $typ ? 'selected' : '' }}>{{ $typ }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kategoria</label>
                        <select name="expense_type_id" id="kategoria-operacji" class="form-select" required>
                            <option value="">Najpierw wybierz typ</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Data</label>
                        <input type="date" name="data" class="form-control" required value="{{ old('data') ?? ($prefill['data'] ?? '') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kwota</label>
                        <input type="number" step="0.01" name="kwota" class="form-control" placeholder="Kwota [zł]" required value="{{ old('kwota') ?? ($prefill['kwota'] ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Notatka</label>
                        <input type="text" name="notatka" class="form-control" placeholder="Notatka" value="{{ old('notatka') ?? ($prefill['notatka'] ?? '') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Wynajmujący</label>
                        <input type="text" id="wynajmujacyInput" class="form-control bg-light" readonly>
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn btn-success">💾 Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


    {{-- FORMULARZ FILTROWANIA --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-bold">🔍 Filtruj wpisy</div>
        <div class="card-body">
            <form method="GET" action="{{ route('finanse.formularz') }}">
    <input type="hidden" name="prefill" value="1">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select">
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ request()->has('data_od') && request('apartment_id') == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Typ</label>
                        <select name="typ" id="typ-filtra" class="form-select">
                            <option value="">Typ</option>
                            @foreach($typyOperacji as $typ)
                                <option value="{{ $typ }}" {{ request('typ') == $typ ? 'selected' : '' }}>{{ $typ }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kategoria</label>
                        <select name="kategoria" id="kategoria-filtra" class="form-select">
                            <option value="">Kategoria</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Od</label>
                        <input type="date" name="data_od" class="form-control" value="{{ request('data_od') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Do</label>
                        <input type="date" name="data_do" class="form-control" value="{{ request('data_do') }}">
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <button type="submit" class="btn btn-outline-primary">Filtruj</button>
                        <a href="{{ route('finanse.formularz') }}" class="btn btn-outline-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABELA --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Data</th>
                            <th>Mieszkanie</th>
                            <th>Typ</th>
                            <th>Kwota</th>
                            <th>Kategoria</th>
                            <th>Wynajmujący</th>
                            <th>Notatka</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finanse as $rekord)
                            <tr>
                                <td>{{ $rekord->data }}</td>
                                <td>{{ $rekord->apartment->adres ?? 'Brak danych' }}</td>
                                <td>
                                    <span class="badge {{ $rekord->typ == 'Przychód' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $rekord->typ }}
                                    </span>
                                </td>
                                <td>{{ number_format($rekord->kwota, 2) }} zł</td>
                                <td>{{ $rekord->kategoria }}</td>
                                <td>{{ $rekord->wynajmujacy ?? '—' }}</td>
                                <td>{{ $rekord->notatka }}</td>
                                <td>
                                    <a href="{{ route('finanse.edytuj', $rekord->id) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('finanse.usun', $rekord->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Czy na pewno chcesz usunąć ten rekord?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Brak danych.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- BILANS --}}
    <div class="alert alert-info text-center fw-bold mt-4">
        💰 Suma przychodów: {{ number_format($sumaPrzychodow, 2) }} zł &nbsp;&nbsp;
        🟢 Suma wydatków: {{ number_format($sumaWydatkow, 2) }} zł &nbsp;&nbsp;
        📊 Bilans: {{ number_format($bilans, 2) }} zł
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typSelect = document.getElementById('typ-operacji');
    const kategoriaSelect = document.getElementById('kategoria-operacji');
    const mieszkanieSelect = document.getElementById('apartmentSelect');
    const wynajmujacyInput = document.getElementById('wynajmujacyInput');

    const prefillExpenseTypeId = @json($prefill['expense_type_id'] ?? null);

    function fetchKategorie(typ, selectElement, selectedValue = null) {
        selectElement.innerHTML = '<option>Ładowanie...</option>';

        fetch(`/api/finanse/kategorie/${encodeURIComponent(typ)}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Wybierz kategorię --</option>';
                data.forEach(cat => {
                    const label = typeof cat === 'string' ? cat : cat.label;
                    const value = typeof cat === 'string' ? cat : cat.value;
                    const selected = selectedValue == value ? 'selected' : '';
                    options += `<option value="${value}" ${selected}>${label}</option>`;
                });
                selectElement.innerHTML = options;
            })
            .catch(() => {
                selectElement.innerHTML = '<option>Błąd pobierania</option>';
            });
    }

    if (typSelect.value) {
        fetchKategorie(typSelect.value, kategoriaSelect, prefillExpenseTypeId);
    }

    typSelect.addEventListener('change', () => {
        fetchKategorie(typSelect.value, kategoriaSelect);
    });

    mieszkanieSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        wynajmujacyInput.value = selected.dataset.wynajmujacy || '';
    });

    // Automatyczne wypełnienie wynajmującego przy prefill
    const selectedOption = mieszkanieSelect.options[mieszkanieSelect.selectedIndex];
    if (selectedOption && selectedOption.dataset.wynajmujacy) {
        wynajmujacyInput.value = selectedOption.dataset.wynajmujacy;
    }
});
</script>
@endpush
@endsection
