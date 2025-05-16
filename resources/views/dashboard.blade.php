@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- 🔸 Umowy kończące się --}}
    <h2 class="mb-4">📅 Umowy kończące się w ciągu 14 dni</h2>

    @if($endingSoonResidents->isEmpty())
        <div class="alert alert-info">Brak mieszkańców z kończącą się umową.</div>
    @else
        <ul class="list-group mb-5">
            @foreach($endingSoonResidents as $resident)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        📌 <strong>Wkrótce wygaśnie umowa:</strong><br>
                        Dnia {{ \Carbon\Carbon::parse($resident->do_kiedy)->format('d.m.Y') }} kończy się umowa w lokalu 
                        <strong>{{ $resident->apartment->miasto ?? '-' }}, {{ $resident->apartment->ulica ?? '' }}</strong> 
                        z <strong>{{ $resident->imie_nazwisko ?? 'Brak danych' }}</strong>.
                    </div>
                    <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-outline-primary btn-sm">
                        ✏️ Edytuj
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- 🔸 Cykliczne finanse --}}
    <h2 class="mb-4">📌 Zaległe operacje finansowe (od początku działania aplikacji)</h2>

    @if($missingCyclicFinances->isEmpty())
        <div class="alert alert-success">Brak zaległych cyklicznych operacji.</div>
    @else
        <ul class="list-group">
            @foreach($missingCyclicFinances as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        💡 <strong>{{ $item['cyclic']->title }} ({{ $item['cyclic']->type === 'income' ? 'Przychód' : 'Wydatek' }})</strong> 
                        za <strong>{{ $item['month']->format('m.Y') }}</strong> w lokalu 
                        <strong>{{ $item['cyclic']->apartment->miasto ?? '-' }}, {{ $item['cyclic']->apartment->ulica ?? '' }}</strong>.<br>
                        Termin to: 
                        <strong>{{ str_pad($item['cyclic']->due_day, 2, '0', STR_PAD_LEFT) }}.{{ $item['month']->format('m.Y') }} r.</strong>
                    </div>
                    <a href="{{ route('finanse.index') }}" class="btn btn-sm btn-outline-warning">
                        ➕ Dodaj płatność
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

</div>
@endsection
