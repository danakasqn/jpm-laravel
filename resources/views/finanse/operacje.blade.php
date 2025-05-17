@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">🛠 Operacje do wykonania</h4>

    @if($pending->isEmpty())
        <div class="alert alert-success">
            Brak operacji do wykonania 🎉
        </div>
    @else
        @foreach($pending as $item)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-2">
                        {{ $item->typ }}: <strong>{{ number_format($item->kwota, 2) }} zł</strong>
                    </h5>

                    <ul class="list-unstyled text-muted mb-3">
                        <li><strong>Kategoria:</strong> {{ $item->kategoria ?? 'brak' }}</li>
                        <li><strong>Lokal:</strong> 
                            {{ optional($item->apartment)->miasto ?? '-' }},
                            {{ optional($item->apartment)->ulica ?? '' }}
                        </li>
                        <li><strong>Data:</strong> {{ \Carbon\Carbon::parse($item->data)->format('d.m.Y') }}</li>
                    </ul>

                    @if($item->id)
                        {{-- Istniejący wpis finansowy --}}
                        <form method="POST" action="{{ route('finanse.zamknij', $item->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">
                                ✅ Oznacz jako wykonane
                            </button>
                        </form>
                    @else
                        {{-- Brak wpisu – przypomnienie cykliczne --}}
                        <a href="{{ route('finanse.formularz') }}" class="btn btn-outline-warning btn-sm">
                            ➕ Dodaj wpis
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
