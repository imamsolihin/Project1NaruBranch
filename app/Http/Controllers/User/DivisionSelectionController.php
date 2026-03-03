<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionSelectionController extends Controller
{
    public function create()
    {
        // Redirect if user already has a division
        if (auth()->user()->division_id) {
            return redirect()->route('dashboard');
        }

        $divisions = Division::all();
        return view('user.select-division', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
        ], [
            'division_id.required' => 'Pilih salah satu divisi terlebih dahulu.',
            'division_id.exists' => 'Divisi yang dipilih tidak valid.'
        ]);

        $user = auth()->user();
        $user->division_id = $request->division_id;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Berhasil bergabung dengan divisi!');
    }
}
