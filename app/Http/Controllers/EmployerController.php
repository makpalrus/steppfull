<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::where('user_id', Auth::id())
            ->withCount('applications')
            ->latest()
            ->paginate(10);
            
        return view('pages.for-employers', compact('vacancies'));
    }

    public function applications(Vacancy $vacancy)
    {
        abort_unless($vacancy->user_id === Auth::id(), 403);
        
        $applications = $vacancy->applications()
            ->with('user')
            ->latest()
            ->get();
            
        return view('employer.applications', compact('vacancy', 'applications'));
    }
}