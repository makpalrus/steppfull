<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create(Vacancy $vacancy)
    {
        return view('applications.create', compact('vacancy'));
    }

    public function store(Request $request, Vacancy $vacancy)
    {
        if (Application::where('user_id', auth()->id())->where('vacancy_id', $vacancy->id)->exists()) {
            return back()->with('error', '⚠️ Вы уже откликались на эту вакансию!');
        }

        Application::create([
            'vacancy_id'   => $vacancy->id,
            'user_id'      => auth()->id(),
            'resume_path'  => $path ?? null,
            'cover_letter' => $request->cover_letter,
            'status'       => 'pending',
        ]);

        return redirect('/vacancies')->with('success', '✅ Отклик отправлен!');
    }

    public function myApplications()
    {
        $applications = Application::where('user_id', auth()->id())
            ->with('vacancy')
            ->latest()
            ->get();

        return view('student.my-applications', compact('applications'));
    }

    public function invite(Application $application)
    {
        abort_unless($application->vacancy->user_id === auth()->id(), 403);
        $application->update(['status' => 'invited']);
        return back()->with('success', '✅ Кандидату отправлено приглашение!');
    }

    public function reject(Application $application)
    {
        abort_unless($application->vacancy->user_id === auth()->id(), 403);
        $application->update(['status' => 'rejected']);
        return back()->with('success', '✅ Статус изменён: Отказано.');
    }

    public function interview(Application $application)
    {
        abort_unless($application->vacancy->user_id === auth()->id(), 403);
        $application->update(['status' => 'interview']);
        return back()->with('success', '📅 Приглашение на собеседование отправлено!');
    }
}