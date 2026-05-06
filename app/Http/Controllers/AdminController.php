<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        $vacancies = Vacancy::with('user')->latest()->get();
        
        $stats = [
            'total_users' => User::count(),
            'total_vacancies' => Vacancy::count(),
            'pending' => Vacancy::where('status', 'pending')->count(),
            'approved' => Vacancy::where('status', 'approved')->count(),
        ];

        return view('admin.dashboard', compact('users', 'vacancies', 'stats'));
    }

    public function toggleBan(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Нельзя заблокировать самого себя!');
        }
        
        $user->update(['is_banned' => !$user->is_banned]);
        
        $message = $user->is_banned 
            ? "Пользователь {$user->name} заблокирован." 
            : "Пользователь {$user->name} разблокирован.";
            
        return back()->with('success', $message);
    }

    public function changeRole(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Нельзя изменить роль самого себя!');
        }

        $request->validate([
            'role' => 'required|in:student,employer,moderator,admin'
        ]);

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        return back()->with('success', "Роль пользователя {$user->name} изменена: {$oldRole} → {$request->role}");
    }

    public function destroyUser(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Нельзя удалить самого себя!');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', "Пользователь {$name} удалён.");
    }
}