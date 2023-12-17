<?php

namespace App\Http\Controllers;

use App\Models\Telpon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TelponController extends Controller
{
    public function index() {
        $data = Telpon::all();
        return Inertia::render('Telpon/Index', compact('data'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required',
            'region' => 'required',
            'telpon' => 'required',
            'description' => 'required',
        ]);

        Telpon::create($validatedData);

        return redirect()->back()->with('Success', 'telpon created successfully.');
    }

    public function update(Request $request, Telpon $telpon) {
        $validatedData = $request->validate([
            'name' => 'required',
            'region' => 'required',
            'telpon' => 'required',
            'description' => 'required',
        ]);

        $telpon->update($validatedData);

        // return redirect()->back()->with('success', 'telpon updated successfully.');
        return redirect()->route('telpon.index');
    }

    public function destroy(Telpon $telpon) {
        $telpon->delete();

        // return redirect()->back()->with('success', 'telpon deleted successfully.');
        return redirect()->route('telpon.index');
    }
}
