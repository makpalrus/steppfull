@extends('layouts.app')
@section('title', __('Добавить мероприятие'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="background:white; max-width:600px; margin:0 auto; padding:30px; border-radius:15px;">
        <h2 style="color:#1e1e2f; margin-bottom:20px;">{{ __('Новое мероприятие') }}</h2>
        <form method="POST" action="{{ route('moderator.events.store') }}">
            @csrf
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Название *') }}</label>
                <input type="text" name="title" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Описание *') }}</label>
                <textarea name="description" rows="3" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;"></textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Дата и время *') }}</label>
                <input type="datetime-local" name="date" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Место / Ссылка') }}</label>
                <input type="text" name="location" placeholder="Zoom / Алматы / Онлайн" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Тип *') }}</label>
                <select name="type" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    <option value="webinar">🌐 Вебинар</option>
                    <option value="workshop">🛠 Мастер-класс</option>
                    <option value="meeting">👥 Встреча</option>
                </select>
            </div>
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-gradient">{{ __('Сохранить') }}</button>
                <a href="{{ route('moderator.events.index') }}" style="padding:12px 25px; background:#f1f5f9; border-radius:8px; text-decoration:none; color:#333; font-weight:700;">{{ __('Отмена') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection