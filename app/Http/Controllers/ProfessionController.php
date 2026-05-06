<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::latest()->paginate(10);
        return view('moderator.professions.index', compact('professions'));
    }

    public function create()
    {
        return view('moderator.professions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary_range' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
        ]);
        
        Profession::create($request->all());
        return redirect()->route('moderator.professions.index')->with('success', '✅ Профессия добавлена');
    }

    public function edit(Profession $profession)
    {
        return view('moderator.professions.edit', compact('profession'));
    }

    public function update(Request $request, Profession $profession)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary_range' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
        ]);
        
        $profession->update($request->all());
        return redirect()->route('moderator.professions.index')->with('success', '✅ Профессия обновлена');
    }

    public function destroy(Profession $profession)
    {
        $profession->delete();
        return back()->with('success', '🗑 Профессия удалена');
    }
}