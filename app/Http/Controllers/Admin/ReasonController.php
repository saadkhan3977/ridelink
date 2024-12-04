<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reason;

class ReasonController extends Controller
{
    public function index()
    {
        $reasons = Reason::all();
        return view('backend.reasons.index', compact('reasons'));
    }

    // Show the form for creating a new reason
    public function create()
    {
        return view('backend.reasons.create');
    }

    // Store a new reason
    public function store(Request $request)
    {
        $request->validate(['description' => 'required|string|max:255']);
        Reason::create($request->only('description'));

        return redirect()->route('reasons.index')->with('success', 'Reason created successfully.');
    }

    // Show the form for editing a reason
    public function edit($id)
    {
        $reason = Reason::findOrFail($id);
        return view('backend.reasons.edit', compact('reason'));
    }

    // Update an existing reason
    public function update(Request $request, $id)
    {
        $request->validate(['description' => 'required|string|max:255']);
        $reason = Reason::findOrFail($id);
        $reason->update($request->only('description'));

        return redirect()->route('reasons.index')->with('success', 'Reason updated successfully.');
    }

    // Delete a reason
    public function destroy($id)
    {
        $reason = Reason::findOrFail($id);
        $reason->delete();

        return redirect()->route('reasons.index')->with('success', 'Reason deleted successfully.');
    }
}
