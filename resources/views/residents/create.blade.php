@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded">

    <h2 class="text-xl font-bold mb-4">Dodaj najemcę</h2>

    <form method="POST" action="{{ route('residents.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Imię i nazwisko</label>
            <input type="text" name="imie_nazwisko" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Mieszkanie</label>
            <select name="apartment_id" class="w-full border rounded px-3 py-2" required>
                @foreach($mieszkania as $mieszkanie)
                    <option value="{{ $mieszkanie->id }}">
                        {{ $mieszkanie->miasto }} - {{ $mieszkanie->ulica }} ({{ $mieszkanie->metraz }} m²)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Data rozpoczęcia</label>
            <input type="date" name="od_kiedy" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Data zakończenia (opcjonalnie)</label>
            <input type="date" name="do_kiedy" class="w-full border rounded px-3 py-2">
            <small class="text-gray-500">Pozostaw puste dla umowy na czas nieokreślony</small>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Komentarz</label>
            <textarea name="komentarz" class="w-full border rounded px-3 py-2 resize-none"
                      rows="2" oninput="this.style.height='';this.style.height=this.scrollHeight + 'px'"></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Zapisz najemcę
        </button>
    </form>
</div>
@endsection
