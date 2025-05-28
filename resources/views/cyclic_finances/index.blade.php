@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">🔁 Finanse cykliczne</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formularz --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Dodaj cykliczny wpis</div>
        <div class="card-body">
            <form action="{{ route('cyclic-finances.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Mieszkanie</label>
                        <select name="apartment_id" class="form-select" id="apartmentSelect">
                            <option value="">Bez przypisania</option>
                            @foreach($apartments as $apartment)
                                <option 
                                    value="{{ $apartment->id }}" 
                                    data-wynajmujacy="{{ $apartment->residents->first()?->wynajmujacy ?? 'Brak danych' }}">
                                    {{ $apartment->miasto }}, {{ $apartment->ulica }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Wynajmujący</label>
                        <input type="text" class="form-control" id="wynajmujacyInput" disabled placeholder="Automatycznie">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Typ</label>
                        <select name="type" class="form-select" id="typ-cykliczny" required>
                            <option value="">-- wybierz --</option>
                            <option value="Przychód">Przychód</option>
                            <option value="Wydatek">Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Kategoria</label>
                        <select name="expense_type_id" class="form-select" id="kategoria-cykliczna" required>
                            <option value="">Najpierw wybierz typ</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Tytuł</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Np. Czynsz, Prąd">
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Dzień</label>
                        <input type="number" name="due_day" class="form-control" min="1" max="31" required>
                    </div>

                    <div class="col-md-1">
                        <label class="form-label">Kwota</label>
                        <input type="number" step="0.01" name="amount" class="form-control" placeholder="Kwota PLN">
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">💾 Zapisz</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabela --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-semibold">Lista zapisanych wpisów</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mieszkanie</th>
                            <th>Wynajmujący</th>
                            <th>Typ</th>
                            <th>Kategoria</th>
                            <th>Tytuł</th>
                            <th>Dzień</th>
                            <th>Kwota</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cyclicFinances as $cf)
                            <tr>
                                <td>{{ $cf->apartment->miasto ?? '-' }}, {{ $cf->apartment->ulica ?? '' }}</td>
                                <td>
                                    @if($cf->apartment && $cf->apartment->residents->last())
                                        {{ $cf->apartment->residents->last()->wynajmujacy }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $cf->type === 'Przychód' ? 'success' : 'danger' }}">
                                        {{ $cf->type }}
                                    </span>
                                </td>
                                <td>{{ $cf->expenseType?->category ?? '—' }}</td>
                                <td>{{ $cf->title }}</td>
                                <td>{{ $cf->due_day }}</td>
                                <td>
                                    @if($cf->expenseType?->category === 'Urząd Skarbowy')
                                        <span class="text-muted">Obliczany dynamicznie</span>
                                    @elseif($cf->amount !== null)
                                        {{ number_format($cf->amount, 2) }} zł
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('cyclic-finances.edit', $cf) }}" class="btn btn-sm btn-outline-primary">✏️</a>
                                    <form action="{{ route('cyclic-finances.destroy', $cf) }}" method="POST" class="d-inline" onsubmit="return confirm('Usunąć wpis?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-muted">Brak danych</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const apartmentSelect = document.getElementById('apartmentSelect');
    const wynajmujacyInput = document.getElementById('wynajmujacyInput');
    const typeSelect = document.getElementById('typ-cykliczny');
    const titleSelect = document.getElementById('kategoria-cykliczna');
    const amountInput = document.querySelector('input[name="amount"]');

    // === Automatyczne uzupełnienie wynajmującego po wyborze mieszkania ===
    apartmentSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        console.log(">>> Mieszkanie:", selected.textContent);
        console.log(">>> data-wynajmujacy:", selected.dataset.wynajmujacy);
        wynajmujacyInput.value = selected.dataset.wynajmujacy || '';
        fetchTax();
    });

    // === Ładowanie kategorii na podstawie typu ===
    typeSelect.addEventListener('change', () => {
        const selectedTyp = typeSelect.value;
        console.log(">>> Wybrany typ:", selectedTyp);

        if (!selectedTyp) {
            titleSelect.innerHTML = '<option value="">Najpierw wybierz typ</option>';
            return;
        }

        titleSelect.innerHTML = '<option value="">Ładowanie...</option>';
        fetch(`/api/finanse/kategorie/${encodeURIComponent(selectedTyp)}`)
            .then(res => res.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) {
                    titleSelect.innerHTML = '<option value="">Brak dostępnych kategorii</option>';
                    return;
                }

                let options = '<option value="">-- Wybierz kategorię --</option>';
                data.forEach(cat => {
                    const label = cat.label || '—';
                    options += `<option value="${cat.value}">${label}</option>`;
                });
                titleSelect.innerHTML = options;
            })
            .catch((err) => {
                console.error('Błąd ładowania kategorii:', err);
                titleSelect.innerHTML = '<option>Błąd ładowania</option>';
            });

        amountInput.value = '';
        amountInput.removeAttribute('readonly');
        amountInput.classList.remove('bg-light');
    });

    // === Reaguj na zmianę kategorii (czy to US) ===
    titleSelect.addEventListener('change', fetchTax);

    async function fetchTax() {
        const apartmentId = apartmentSelect.value;
        const selectedText = titleSelect.options[titleSelect.selectedIndex]?.textContent || '';
        const isTax = selectedText.toLowerCase().includes('urząd skarbowy');

        if (apartmentId && isTax) {
            try {
                const res = await fetch(`/api/podatek?apartment_id=${apartmentId}`);
                const data = await res.json();
                amountInput.value = data.amount ?? '';
                amountInput.setAttribute('readonly', 'readonly');
                amountInput.classList.add('bg-light');
            } catch (err) {
                console.error('Błąd podczas pobierania podatku:', err);
                amountInput.value = '';
                amountInput.removeAttribute('readonly');
                amountInput.classList.remove('bg-light');
            }
        } else {
            amountInput.removeAttribute('readonly');
            amountInput.classList.remove('bg-light');
        }
    }

    // Auto-ładowanie kategorii po przeładowaniu, jeśli typ wybrany
    if (typeSelect.value) {
        fetch(`/api/finanse/kategorie/${encodeURIComponent(typeSelect.value)}`)
            .then(res => res.json())
            .then(data => {
                let options = '<option value="">-- Wybierz kategorię --</option>';
                data.forEach(cat => {
                    options += `<option value="${cat.value}">${cat.label}</option>`;
                });
                titleSelect.innerHTML = options;
            });
    }

    console.log("🚀 Skrypt JS załadowany i działa.");
});
</script>
@endpush

@endsection
