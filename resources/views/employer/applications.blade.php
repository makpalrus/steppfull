@extends('layouts.app')
@section('title', __('Отклики на вакансию'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <a href="{{ route('for-employers') }}" 
       style="color:#FF6B47; text-decoration:none; font-weight:700; margin-bottom:20px; display:inline-block;">
        ← {{ __('Назад к вакансиям') }}
    </a>
    
    <h1 style="color:white; margin-bottom:10px;">{{ $vacancy->title }}</h1>
    <p style="color:rgba(255,255,255,.6); margin-bottom:30px;">
        {{ $vacancy->company }} • {{ __('Всего откликов') }}: {{ $applications->count() }}
    </p>

    @if($applications->isEmpty())
        <div style="text-align:center; color:rgba(255,255,255,.6); padding:40px; background:rgba(255,255,255,.05); border-radius:15px;">
            {{ __('Пока нет откликов на эту вакансию.') }}
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:15px;">
            @foreach($applications as $app)
            <div style="background:white; border-radius:12px; padding:20px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
                <div style="flex:1; min-width:200px;">
                    {{-- Клик по имени открывает модалку --}}
                    <a href="#" data-toggle="modal" data-target="#applicantModal{{ $app->id }}" 
                       style="color:#1e1e2f; font-weight:700; font-size:1.1rem; text-decoration:none;">
                        👤 {{ $app->user->name }}
                    </a>
                    <p style="color:#888; margin:5px 0 0; font-size:14px;">{{ $app->user->email }}</p>
                </div>
                <div style="display:flex; align-items:center; gap:15px;">
                    <span style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700;
                        background:{{ $app->status==='invited'?'#cce5ff':($app->status==='rejected'?'#f8d7da':($app->status==='interview'?'#d4edda':'#fff3cd')) }};
                        color:{{ $app->status==='invited'?'#004085':($app->status==='rejected'?'#721c24':($app->status==='interview'?'#155724':'#856404')) }};">
                        {{ $app->status === 'pending' ? '⏳ Новый' : 
                           ($app->status === 'invited' ? '✅ Приглашён' : 
                           ($app->status === 'interview' ? '📅 Собеседование' : '❌ Отказ')) }}
                    </span>
                </div>
            </div>

            {{-- 🔹 МОДАЛЬНОЕ ОКНО --}}
            <div class="modal fade" id="applicantModal{{ $app->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content" style="border-radius:15px; overflow:hidden; border:none;">
                        <div class="modal-header" style="background:#1e1e2f; color:white; border-bottom:none; padding:15px 20px;">
                            <h5 class="modal-title" style="font-weight:700;">👤 {{ $app->user->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" style="color:white; font-size:1.5rem;">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding:25px; background:#f8f9fc;">
                            <div style="display:grid; gap:15px;">
                                {{-- Email --}}
                                <div>
                                    <p style="margin:0 0 5px; color:#888; font-size:12px; text-transform:uppercase;">Email</p>
                                    <p style="margin:0; font-weight:600; color:#1e1e2f;">{{ $app->user->email }}</p>
                                </div>
                                
                                {{-- Год рождения --}}
                                <div>
                                    <p style="margin:0 0 5px; color:#888; font-size:12px; text-transform:uppercase;">Возраст / Год рождения</p>
                                    <p style="margin:0; font-weight:600; color:#1e1e2f;">
                                        {{ $app->user->birth_year ?? 'Не указан' }}
                                        @if(isset($app->user->birth_year)) 
                                            ({{ date('Y') - $app->user->birth_year }} лет)
                                        @endif
                                    </p>
                                </div>
                                
                                {{-- Сопроводительное письмо --}}
                                <div>
                                    <p style="margin:0 0 5px; color:#888; font-size:12px; text-transform:uppercase;">Сообщение / Сопроводительное</p>
                                    <div style="background:white; padding:12px; border-radius:8px; border-left:3px solid #FF6B47; color:#444; font-size:14px; line-height:1.5;">
                                        {{ $app->cover_letter ?? 'Без сообщения' }}
                                    </div>
                                </div>
                                
                                {{-- Резюме --}}
                                <div>
                                    <p style="margin:0 0 8px; color:#888; font-size:12px; text-transform:uppercase;">Резюме</p>
                                    @if($app->resume_path)
                                        <a href="{{ asset('storage/' . $app->resume_path) }}" target="_blank" 
                                           style="display:inline-block; padding:10px 20px; background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; border-radius:8px; text-decoration:none; font-weight:700; font-size:13px;">
                                            📥 {{ __('Скачать резюме') }}
                                        </a>
                                    @else
                                        <span style="color:#999; font-size:14px;">{{ __('Резюме не загружено') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="background:white; border-top:1px solid #eee; padding:15px 20px; display:flex; gap:10px; justify-content:flex-end;">
                            @if($app->status === 'pending')
                                {{-- Кнопка Отказать --}}
                                <form method="POST" action="{{ route('applications.reject', $app->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" 
                                            style="background:#dc3545; color:white; padding:10px 22px; border-radius:10px; font-weight:700; font-size:13px; border:none; cursor:pointer;">
                                        ❌ {{ __('Отказать') }}
                                    </button>
                                </form>
                                
                                {{-- Кнопка Собеседование --}}
                                <form method="POST" action="{{ route('applications.interview', $app->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" 
                                            style="background:#28a745; color:white; padding:10px 22px; border-radius:10px; font-weight:700; font-size:13px; border:none; cursor:pointer;">
                                        📅 {{ __('Пригласить на собеседование') }}
                                    </button>
                                </form>
                            @else
                                <button class="btn" disabled 
                                        style="background:#e9ecef; color:#6c757d; padding:10px 22px; border-radius:10px; font-weight:700; font-size:13px; border:none;">
                                    {{ __('Статус уже изменён') }}
                                </button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius:8px;">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- 🔹 КОНЕЦ МОДАЛКИ --}}
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
// Защита от повторной отправки
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        this.querySelectorAll('button[type="submit"]').forEach(btn => {
            btn.disabled = true;
            btn.style.opacity = '0.7';
        });
    });
});
</script>
@endpush
@endsection