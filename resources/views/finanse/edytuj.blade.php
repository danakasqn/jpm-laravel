<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edytuj Rekord</h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('finanse.aktualizuj', $rekord->id) }}">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="date" name="data" class="form-control" value="{{ old('data', $rekord->data) }}" required>
                    </div>

                    <div class="col-md-3">
                        <select name="apartment_id" class="form-select" required>
                            <option value="">Wybierz mieszkanie</option>
                            @foreach($apartments as $apartment)
                                <option value="{{ $apartment->id }}" {{ $rekord->apartment_id == $apartment->id ? 'selected' : '' }}>
                                    {{ $apartment->adres }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="typ" class="form-select" required>
                            <option value="Przychód" {{ $rekord->typ == 'Przychód' ? 'selected' : '' }}>Przychód</option>
                            <option value="Wydatek" {{ $rekord->typ == 'Wydatek' ? 'selected' : '' }}>Wydatek</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <input type="number" step="0.01" name="kwota" class="form-control" value="{{ old('kwota', $rekord->kwota) }}" required>
                    </div>

                    <div class="col-md-2">
                        <select name="kategoria" class="form-select">
                            <option value="">Wybierz kategorię</option>
                            @php
                                $kategorie = ['Czynsz najmu', 'Czynsz administracyjny', 'Prąd', 'Urząd Skarbowy', 'Inne'];
                            @endphp
                            @foreach($kategorie as $kat)
                                <option value="{{ $kat }}" {{ old('kategoria', $rekord->kategoria) == $kat ? 'selected' : '' }}>
                                    {{ $kat }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="notatka" class="form-control" value="{{ old('notatka', $rekord->notatka) }}" placeholder="Notatka">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">✅ Aktualizuj</button>
                    <a href="{{ route('finanse.index') }}" class="btn btn-secondary">↩️ Anuluj</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
