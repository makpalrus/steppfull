@extends('layouts.app')
@section('title', __('Мой профиль'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px; color:white;">
    <div style="max-width:1100px; margin:0 auto;">
        <h1 style="text-align:center; margin-bottom:40px;">{{ __('Мой профиль') }}</h1>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:30px;">
            {{-- Левая колонка — Информация о пользователе --}}
            <div style="background:white; color:#1e1e2f; border-radius:20px; padding:30px;">
                <div style="text-align:center; margin-bottom:25px;">
                    <div style="width:120px; height:120px; background:linear-gradient(135deg,#FF6B47,#F5A623);
                        border-radius:50%; margin:0 auto 15px; display:flex; align-items:center;
                        justify-content:center; color:white; font-size:48px;">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <h3>{{ auth()->user()->name }}</h3>
                    <p style="color:#666;">{{ auth()->user()->email }}</p>
                    <span style="padding:5px 15px; background:#e8f4ff; color:#004085; border-radius:20px; font-size:14px;">
                        {{ auth()->user()->role }}
                    </span>
                </div>
                <hr style="margin:25px 0;">
                <p><strong>{{ __('Дата регистрации') }}:</strong> {{ auth()->user()->created_at->format('d.m.Y') }}</p>
                
                {{-- Год рождения для студентов --}}
                @if(auth()->user()->role === 'student')
                <p style="margin-top:10px;">
                    <strong>{{ __('Год рождения') }}:</strong> 
                    {{ auth()->user()->birth_year ?? 'Не указан' }}
                    @if(auth()->user()->birth_year)
                        ({{ date('Y') - auth()->user()->birth_year }} лет)
                    @endif
                </p>
                @endif
            </div>

            {{-- Центральная колонка — Резюме (только для студентов) --}}
            @if(auth()->user()->role === 'student')
            <div style="background:white; color:#1e1e2f; border-radius:20px; padding:30px;">
                <h3 style="margin-bottom:20px;">📄 {{ __('Моё резюме') }}</h3>
                @if(auth()->user()->resume_path)
                    <p>✅ {{ __('Резюме загружено') }}</p>
                    <a href="{{ asset('storage/' . auth()->user()->resume_path) }}" target="_blank" 
                       class="btn-gradient" style="display:inline-block; margin-top:10px;">
                        📥 {{ __('Скачать резюме') }}
                    </a>
                    <form method="POST" action="{{ route('profile.update') }}" 
                          enctype="multipart/form-data" style="margin-top:20px;">
                        @csrf @method('PUT')
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" 
                               style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                        <button type="submit" class="btn-gradient" 
                                style="margin-top:10px; padding:10px 20px; font-size:13px;">
                            🔄 {{ __('Заменить резюме') }}
                        </button>
                    </form>
                @else
                    <p>{{ __('Резюме ещё не загружено') }}</p>
                    <form method="POST" action="{{ route('profile.update') }}" 
                          enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <input type="file" name="resume" accept=".pdf,.doc,.docx" required 
                               style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; margin-bottom:10px;">
                        <button type="submit" class="btn-gradient" 
                                style="padding:10px 20px; font-size:13px;">
                            ⬆️ {{ __('Загрузить резюме') }}
                        </button>
                    </form>
                @endif
            </div>
            @endif
        </div>

        {{-- Кнопки действий --}}
        <div style="margin-top:40px; text-align:center; display:flex; gap:15px; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('profile.edit') }}" 
               style="background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; padding:12px 30px; border-radius:10px; text-decoration:none; font-weight:700;">
                ✏️ {{ __('Редактировать профиль') }}
            </a>
            <form action="/logout" method="POST" style="display:inline">
                @csrf
                <button type="submit" style="background:#f8f9fa; color:#475569; padding:12px 30px; border-radius:10px; border:none; cursor:pointer; font-weight:700;">
                    🚪 {{ __('Выйти') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection