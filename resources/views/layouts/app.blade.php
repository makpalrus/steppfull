<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StepUp | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Step<span style="color:#FF6B47">Up</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item"><a class="nav-link" href="/">{{ __('Главная') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="/vacancies">{{ __('Вакансии') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('career-library') }}">{{ __('Библиотека профессий') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('career-test') }}">{{ __('Тест на профессию') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">{{ __('Мероприятия') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">{{ __('О нас') }}</a></li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @auth
                        <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">{{ __('Мой профиль') }}</a></li>
                        @if(auth()->user()->role === 'employer' || auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('for-employers') }}">{{ __('Для работодателей') }}</a></li>
                        @endif
                        <li class="nav-item"><span class="nav-link" style="color: rgba(255,255,255,.7)">{{ auth()->user()->name }}</span></li>
                        <li class="nav-item">
                            <form action="/logout" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link" style="color:rgba(255,255,255,.7); cursor:pointer">{{ __('Выход') }}</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="/register">{{ __('Регистрация') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="/login">{{ __('Войти') }}</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ __('Контакты') }}</a></li>
                    @endauth
                    @include('partials.lang-switcher')
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="main-footer" style="background:#1e1e2f; color:rgba(255,255,255,.5); text-align:center; padding:20px;">
        <p>{{ __('© StepUp 2026 — Гид для студентов по поиску работы') }}</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>

    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    @if(session('error'))
        <script>alert("{{ session('error') }}");</script>
    @endif

    @if($errors->any())
        <script>alert("{{ $errors->first() }}");</script>
    @endif

    @stack('scripts')
</body>
</html>