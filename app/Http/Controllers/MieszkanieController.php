<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mieszkanie;

class MieszkanieController extends Controller
{
    public function index()
    {
        $mieszkania = Mieszkanie::all();
        return view('mieszkania.index', compact('mieszkania'));
    }

    public function zapisz(Request $request)
    {
        $validated = $request->validate([
            'miasto' => 'required|string|max:255',
            'ulica' => 'required|string|max:255',
            'metraz' => 'required|numeric|min:0',
            'wspolnota' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notatka' => 'nullable|string|max:1000',
        ]);

        // Dodaj dynamicznie adres
        $validated['adres'] = $validated['miasto'] . ', ' . $validated['ulica'];

        Mieszkanie::create($validated);

        return redirect()->route('mieszkania.index')->with('sukces', 'Dodano mieszkanie.');
    }

    public function edytuj($id)
    {
        $mieszkanie = Mieszkanie::findOrFail($id);
        return view('mieszkania.edytuj', compact('mieszkanie'));
    }

    public function aktualizuj(Request $request, $id)
    {
        $validated = $request->validate([
            'miasto' => 'required|string|max:255',
            'ulica' => 'required|string|max:255',
            'metraz' => 'required|numeric|min:0',
            'wspolnota' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'notatka' => 'nullable|string|max:1000',
        ]);

        // Dodaj dynamicznie adres
        $validated['adres'] = $validated['miasto'] . ', ' . $validated['ulica'];

        $mieszkanie = Mieszkanie::findOrFail($id);
        $mieszkanie->update($validated);

        return redirect()->route('mieszkania.index')->with('sukces', 'Zaktualizowano dane mieszkania.');
    }

    public function usun($id)
    {
        Mieszkanie::destroy($id);
        return redirect()->route('mieszkania.index')->with('sukces', 'Mieszkanie usunięte.');
    }
}
