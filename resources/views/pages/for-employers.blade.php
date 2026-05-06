@extends('layouts.app')
@section('title', __('Для работодателей'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px; margin-bottom:30px;">
        <h1 style="color:white; margin:0;">{{ __('Мои вакансии') }}</h1>
        <a href="/vacancies/create" class="btn-gradient" style="padding:12px 25px; font-size:14px;">+ {{ __('Создать вакансию') }}</a>
    </div>

    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap:20px;">
        @forelse($vacancies as $v)
        <div style="background:white; border-radius:15px; padding:25px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
            <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:15px;">
                <h3 style="color:#1e1e2f; margin:0; font-size:1.2rem;">{{ $v->title }}</h3>
                <span style="padding:5px 10px; border-radius:20px; font-size:11px; font-weight:700;
                    background:{{ $v->status==='approved'?'#d4edda':($v->status==='pending'?'#fff3cd':'#f8d7da') }};
                    color:{{ $v->status==='approved'?'#155724':($v->status==='pending'?'#856404':'#721c24') }};">
                    {{ $v->status === 'approved' ? '✅ Активна' : ($v->status === 'pending' ? '⏳ Модерация' : '❌ Отклонена') }}
                </span>
            </div>
            <p style="color:#666; font-size:14px; margin-bottom:20px;">{{ Str::limit($v->description, 100) }}</p>
            
            <div style="border-top:1px solid #eee; padding-top:15px; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#888; font-size:14px;"> {{ $v->applications_count }} {{ __('откликов') }}</span>
                <a href="{{ route('employer.applications', $v->id) }}" 
                   style="padding:10px 20px; background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; border-radius:8px; text-decoration:none; font-weight:700; font-size:13px;">
                    {{ __('Смотреть отклики') }} →
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; color:rgba(255,255,255,.6); padding:40px; background:rgba(255,255,255,.05); border-radius:15px;">
            <p>{{ __('У вас пока нет вакансий. Создайте первую!') }}</p>
            <a href="/vacancies/create" class="btn-gradient" style="margin-top:15px; display:inline-block;">{{ __('Создать вакансию') }}</a>
        </div>
        @endforelse
    </div>
    @if($vacancies->hasPages())
        <div style="margin-top:30px;">{{ $vacancies->links() }}</div>
    @endif
</div>
@endsection