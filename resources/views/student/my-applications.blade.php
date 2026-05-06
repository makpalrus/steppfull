@extends('layouts.app')
@section('title', __('Мои отклики'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <h1 style="color:white; text-align:center; margin-bottom:40px;">{{ __('Мои отклики') }}</h1>

    @if($applications->isEmpty())
        <div style="text-align:center; color:rgba(255,255,255,.6); padding:50px; background:rgba(255,255,255,.05); border-radius:15px;">
            <p style="font-size:1.1rem;">{{ __('Вы ещё не откликались на вакансии.') }}</p>
            <a href="/vacancies" class="btn-gradient" style="margin-top:15px; display:inline-block;">{{ __('Найти вакансию') }}</a>
        </div>
    @else
        <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:20px;">
            @foreach($applications as $app)
            <div style="background:white; border-radius:15px; padding:25px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
                <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:12px;">
                    <h3 style="color:#1e1e2f; margin:0; font-size:1.15rem;">{{ $app->vacancy->title }}</h3>
                    {{-- Статус бейдж --}}
                    @php
                        $statusConfig = match($app->status) {
                            'pending'   => ['bg' => '#fff3cd', 'color' => '#856404', 'text' => '⏳ На рассмотрении'],
                            'invited'   => ['bg' => '#d1e7dd', 'color' => '#0f5132', 'text' => '✅ Приглашён'],
                            'interview' => ['bg' => '#cff4fc', 'color' => '#055160', 'text' => '📅 Собеседование'],
                            'rejected'  => ['bg' => '#f8d7da', 'color' => '#842029', 'text' => '❌ Отказ'],
                            default     => ['bg' => '#e9ecef', 'color' => '#495057', 'text' => $app->status]
                        };
                    @endphp
                    <span style="padding:5px 12px; border-radius:20px; font-size:11px; font-weight:700;
                        background:{{ $statusConfig['bg'] }}; color:{{ $statusConfig['color'] }};">
                        {{ $statusConfig['text'] }}
                    </span>
                </div>
                
                <p style="color:#FF6B47; font-weight:600; margin:0 0 10px;">{{ $app->vacancy->company }}</p>
                <p style="color:#888; font-size:13px; margin:0 0 15px;">{{ $app->vacancy->location ?? '🌍 Локация не указана' }}</p>
                
                <div style="border-top:1px solid #eee; padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
                    <span style="color:#aaa; font-size:12px;">{{ __('Отклик отправлен') }}: {{ $app->created_at->format('d.m.Y') }}</span>
                    <a href="/vacancies/{{ $app->vacancy->id }}" style="color:#FF6B47; font-size:13px; font-weight:700; text-decoration:none;">
                        {{ __('Подробнее') }} →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection