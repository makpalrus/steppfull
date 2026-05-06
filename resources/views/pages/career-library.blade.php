@extends('layouts.app')
@section('title', __('Библиотека профессий'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px; color:white;">
    <h1 style="text-align:center; margin-bottom:40px;">{{ __('Библиотека профессий') }}</h1>
    @auth
        @if(in_array(auth()->user()->role, ['moderator', 'admin']))
            <div style="text-align:center; margin-bottom:30px;">
                <a href="{{ route('moderator.professions.create') }}" class="btn-gradient">+ {{ __('Добавить профессию') }}</a>
            </div>
        @endif
    @endauth
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:25px;">
        @php $professions = \App\Models\Profession::all(); @endphp
        @forelse($professions as $prof)
        <div style="background:white; color:#1e1e2f; border-radius:15px; padding:25px;">
            <h3 style="color:#FF6B47;">{{ $prof->icon ?? '💼' }} {{ $prof->title }}</h3>
            <p><strong>{{ __('Зарплата') }}:</strong> {{ $prof->salary_range ?? '—' }}</p>
            <p>{{ Str::limit($prof->description, 150) }}</p>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; color:rgba(255,255,255,.6); padding:40px;">
            {{ __('Профессии появятся в ближайшее время...') }}
        </div>
        @endforelse
    </div>
</div>
@endsection