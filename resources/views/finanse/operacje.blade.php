@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4 fw-semibold">🛠 Operacje do wykonania</h3>

    @if($pending->isEmpty())
        <div class="alert alert-success">Brak operacji do wykonania 🎉</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Typ</th>
                        <th>Typ wydatku</th>
                        <th>Kategoria</th>
                        <th>Kwota</th>
                        <th>Lokal</th>
                        <th>Właściciel</th>
                        <th>Data</th>
                        <th>Akcja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending as $item)
                        <tr>
                            <td>
                                <span class="badge bg-{{ $item->typ === 'Przychód' ? 'success' : 'danger' }}">
                                    {{ $item->typ }}
                                </span>
                            </td>
                            <td>{{ $item->expenseType->name ?? '—' }}</td>
                            <td>{{ $item->expenseType->category ?? '—' }}</td>
                            <td>
                                @if(isset($item->kwota) && is_numeric($item->kwota))
                                    {{ number_format($item->kwota, 2) }} zł
                                    @if(!empty($item->tax_suggestion))
                                        <span title="Sugerowana kwota podatku">⚡</span>
                                    @endif
                                @elseif(isset($item->amount) && is_numeric($item->amount))
                                    {{ number_format($item->amount, 2) }} zł
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                {{ optional($item->apartment)->miasto ?? '-' }},
                                {{ optional($item->apartment)->ulica ?? '' }}
                            </td>
                            <td>{{ optional(optional($item->apartment)->residents)->last()?->wynajmujacy ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->data)->format('d.m.Y') }}</td>
                            <td>
                                @if($item->id)
                                    <form method="POST" action="{{ route('finanse.zamknij', $item->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">✅ Wykonane</button>
                                    </form>
                                @else
                                    <form method="GET" action="{{ route('finanse.formularz') }}">
                                        <input type="hidden" name="typ" value="{{ $item->typ }}">
                                        <input type="hidden" name="kwota" value="{{ $item->kwota ?? $item->amount }}">
                                        <input type="hidden" name="data" value="{{ $item->data }}">
                                        <input type="hidden" name="apartment_id" value="{{ optional($item->apartment)->id }}">
                                        <input type="hidden" name="expense_type_id" value="{{ $item->expense_type_id }}">
                                        <input type="hidden" name="notatka" value="Wygenerowano automatycznie">
                                        <button type="submit" class="btn btn-sm btn-warning">➕ Dodaj wpis</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
