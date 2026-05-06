<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('pages.profile');
    }

    public function edit()
    {
        return view('pages.profile-edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:6|confirmed',
        ];

        if ($user->role === 'student') {
            $rules['birth_year'] = 'nullable|numeric|digits:4|min:1950|max:' . date('Y');
            $rules['resume'] = 'nullable|file|mimes:pdf,doc,docx|max:2048';
        }

        $validated = $request->validate($rules);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($user->role === 'student' && isset($validated['birth_year'])) {
            $data['birth_year'] = $validated['birth_year'];
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($validated['password']);
        }

        if ($user->role === 'student' && $request->hasFile('resume')) {
            if ($user->resume_path) {
                $oldPath = public_path('storage/' . $user->resume_path);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $path = $request->file('resume')->store('resumes', 'public');
            $data['resume_path'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile')->with('success', '✅ Профиль успешно обновлён!');
    }

    public function removeResume()
    {
        $user = Auth::user();

        if ($user->resume_path) {
            $path = public_path($user->resume_path);
            if (file_exists($path)) {
                unlink($path);
            }
            $user->update(['resume_path' => null]);
            return back()->with('success', '🗑 Резюме удалено');
        }

        return back()->with('error', 'Резюме не найдено');
    }
}