@extends('layouts.app')
@section('title', __('Мероприятия'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:60px 20px; color:white;">
    <h1 style="text-align:center;">{{ __('Мероприятия') }}</h1>
    <p style="text-align:center; font-size:1.3rem;">{{ __('Бесплатные вебинары, мастер-классы и встречи с экспертами') }}</p>
    @auth
        @if(in_array(auth()->user()->role, ['moderator', 'admin']))
            <div style="text-align:center; margin:30px 0;">
                <a href="{{ route('moderator.events.create') }}" class="btn-gradient">+ {{ __('Добавить мероприятие') }}</a>
            </div>
        @endif
    @endauth
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:20px; margin-top:40px;">
        @php $events = \App\Models\Event::where('date','>=',now())->orderBy('date')->get(); @endphp
        @forelse($events as $event)
        <div style="background:white; color:#1e1e2f; border-radius:15px; padding:25px;">
            <h3 style="color:#FF6B47; margin:0 0 10px;">{{ $event->title }}</h3>
            <p style="color:#666; font-size:14px; margin-bottom:15px;">
                📅 {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y H:i') }} • 
                {{ $event->type === 'webinar' ? '🌐 Вебинар' : ($event->type === 'workshop' ? '🛠 Мастер-класс' : '👥 Встреча') }}
            </p>
            <p style="color:#444; font-size:14px; margin-bottom:20px;">{{ Str::limit($event->description, 120) }}</p>
            @if($event->location)<p style="color:#888; font-size:13px;">📍 {{ $event->location }}</p>@endif
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align:center; color:rgba(255,255,255,.6); padding:40px;">
            {{ __('Мероприятия появятся в ближайшее время...') }}
        </div>
        @endforelse
    </div>
</div>
@endsection