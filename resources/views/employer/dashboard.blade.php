@extends('layouts.app')
@section('title', __('Кабинет работодателя'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <h1 style="color:white; text-align:center; margin-bottom:40px;">{{ __('Кабинет работодателя') }}</h1>
    
    <a href="/vacancies/create" class="btn-gradient" style="margin-bottom:30px; display:inline-block;">
        + {{ __('Разместить новую вакансию') }}
    </a>

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:20px;">{{ session('success') }}</div>
    @endif

    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap:25px;">
        @forelse($vacancies as $vacancy)
        <div style="background:white; border-radius:15px; padding:25px;">
            <h3 style="color:#1e1e2f; margin:0 0 10px;">{{ $vacancy->title }}</h3>
            <p style="color:#888; font-size:14px; margin-bottom:15px;">
                {{ $vacancy->company }} • 
                {{ $vacancy->status === 'approved' ? '✅ Активна' : 
                   ($vacancy->status === 'pending' ? '⏳ На модерации' : '❌ Отклонена') }}
            </p>
            <div style="border-top:1px solid #eee; padding-top:15px; display:flex; justify-content:space-between; align-items:center;">
                <span style="color:#555; font-size:14px;">
                    👥 {{ $vacancy->applications_count ?? $vacancy->applications->count() }} {{ __('откликов') }}
                </span>
                <a href="{{ route('employer.applications', $vacancy->id) }}" 
                   class="btn-gradient" style="padding:10px 20px; font-size:14px;">
                    {{ __('Просмотреть') }} →
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; color:rgba(255,255,255,.6); padding:40px;">
            {{ __('У вас пока нет размещенных вакансий.') }}
        </div>
        @endforelse
    </div>
    
    <div style="margin-top:20px;">{{ $vacancies->links() }}</div>
</div>
@endsection