@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-xl font-bold mb-4">Edytuj najemcę</h2>

    <form method="POST" action="{{ route('residents.update', $resident->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Imię i nazwisko</label>
            <input type="text" name="imie_nazwisko" value="{{ $resident->imie_nazwisko }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Mieszkanie</label>
            <select name="apartment_id" class="w-full border rounded px-3 py-2" required>
                @foreach($mieszkania as $mieszkanie)
                    <option value="{{ $mieszkanie->id }}" @if($resident->apartment_id == $mieszkanie->id) selected @endif>
                        {{ $mieszkanie->miasto }}, {{ $mieszkanie->ulica }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Od kiedy</label>
            <input type="date" name="od_kiedy" value="{{ $resident->od_kiedy }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Do kiedy</label>
            <input type="date" name="do_kiedy" value="{{ $resident->do_kiedy }}" class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Komentarz</label>
            <textarea name="komentarz" class="w-full border rounded px-3 py-2 resize-none"
                      rows="2" oninput="this.style.height='';this.style.height=this.scrollHeight + 'px'">{{ old('komentarz', $resident->komentarz) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Zapisz zmiany</button>
    </form>
</div>
@endsection
