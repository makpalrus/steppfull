<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController, BlogController, AuthController,
    VacancyController, AdminController, ApplicationController,
    MailController, LocalizationController, EmployerController,
    ProfileController, ProfessionController, EventController, TestController
};

Route::get('/lang/{locale}', [LocalizationController::class, 'index'])
    ->where('locale', 'ru|kz|en')->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/about', fn()=>view('pages.about'))->name('about');
Route::get('/contact', fn()=>view('pages.contact'))->name('contact');
Route::get('/events', fn()=>view('events.index'))->name('events');
Route::get('/career-library', fn()=>view('pages.career-library'))->name('career-library');
Route::get('/career-test', fn()=>view('pages.career-test'))->name('career-test');

Route::middleware('guest')->group(function(){
    Route::get('/register',[AuthController::class,'showRegister'])->name('register');
    Route::post('/register',[AuthController::class,'register']);
    Route::get('/login',[AuthController::class,'showLogin'])->name('login');
    Route::post('/login',[AuthController::class,'login']);
});

Route::middleware('auth')->group(function(){
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::get('/profile',[ProfileController::class,'show'])->name('profile');
    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::put('/profile',[ProfileController::class,'update'])->name('profile.update');

    Route::get('/vacancies',[VacancyController::class,'index'])->name('vacancies.index');
    Route::get('/vacancies/{vacancy}',[VacancyController::class,'show'])->name('vacancies.show');

    Route::middleware('role:student')->group(function(){
        Route::get('/vacancies/{vacancy}/apply',[ApplicationController::class,'create']);
        Route::post('/vacancies/{vacancy}/apply',[ApplicationController::class,'store']);
        Route::get('/my-applications',[ApplicationController::class,'myApplications'])->name('student.applications');
    });

    Route::middleware('role:employer,admin')->group(function(){
        Route::get('/for-employers',[EmployerController::class,'index'])->name('for-employers');
        Route::get('/vacancies/create',[VacancyController::class,'create'])->name('vacancies.create');
        Route::post('/vacancies',[VacancyController::class,'store'])->name('vacancies.store');
        Route::get('/employer/vacancy/{vacancy}/applicants',[EmployerController::class,'applicants'])->name('employer.applicants');
    });

    Route::middleware('role:employer,moderator,admin')->group(function(){
        Route::get('/vacancies/{vacancy}/edit',[VacancyController::class,'edit'])->name('vacancies.edit');
        Route::put('/vacancies/{vacancy}',[VacancyController::class,'update'])->name('vacancies.update');
        Route::delete('/vacancies/{vacancy}',[VacancyController::class,'destroy'])->name('vacancies.destroy');
    });

    Route::middleware('role:employer,admin')->group(function(){
        Route::post('/applications/{application}/invite',[ApplicationController::class,'invite'])->name('applications.invite');
        Route::post('/applications/{application}/reject',[ApplicationController::class,'reject'])->name('applications.reject');
        Route::post('/applications/{application}/interview',[ApplicationController::class,'interview'])->name('applications.interview');
    });

    Route::middleware('role:moderator,admin')->prefix('moderator')->name('moderator.')->group(function(){
        Route::resource('professions', ProfessionController::class);
        Route::resource('events', EventController::class);
        Route::get('/tests',[TestController::class,'index'])->name('tests.index');
        Route::post('/tests',[TestController::class,'store'])->name('tests.store');
        Route::delete('/tests/{id}',[TestController::class,'destroy'])->name('tests.destroy');
    });

    Route::middleware('role:admin')->group(function(){
        Route::get('/admin/dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    });

    Route::get('/mail/send',[MailController::class,'send']);
});
Route::middleware('role:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::post('/admin/users/{user}/toggle-ban', [AdminController::class, 'toggleBan'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('admin.users.role');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});