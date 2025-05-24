<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Mieszkanie;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::with('apartment')->get();
        $mieszkania = Mieszkanie::all();

        return view('residents.index', compact('residents', 'mieszkania'));
    }

    public function create()
    {
        $mieszkania = Mieszkanie::all();
        return view('residents.create', compact('mieszkania'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'wynajmujacy' => 'nullable|string|max:255', // ✅ dodane
            'apartment_id' => 'required|exists:mieszkania,id',
            'od_kiedy' => 'required|date',
            'do_kiedy' => 'nullable|date|after_or_equal:od_kiedy',
            'komentarz' => 'nullable|string',
        ]);

        Resident::create($validated);

        return redirect()->route('residents.index')->with('sukces', 'Najemca został dodany');
    }

    public function edit(Resident $resident)
    {
        $mieszkania = Mieszkanie::all();
        return view('residents.edit', compact('resident', 'mieszkania'));
    }

    public function update(Request $request, Resident $resident)
    {
        $validated = $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'wynajmujacy' => 'nullable|string|max:255', // ✅ dodane
            'apartment_id' => 'required|exists:mieszkania,id',
            'od_kiedy' => 'required|date',
            'do_kiedy' => 'nullable|date|after_or_equal:od_kiedy',
            'komentarz' => 'nullable|string',
        ]);

        $resident->update($validated);

        return redirect()->route('residents.index')->with('sukces', 'Dane najemcy zostały zaktualizowane');
    }

    public function destroy(Resident $resident)
    {
        $resident->delete();

        return redirect()->route('residents.index')->with('sukces', 'Najemca został usunięty');
    }
}
