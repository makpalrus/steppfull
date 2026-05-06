@extends('layouts.app')
@section('title', __('Редактировать мероприятие'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="background:white; max-width:600px; margin:0 auto; padding:30px; border-radius:15px;">
        <h2 style="color:#1e1e2f; margin-bottom:20px;">{{ __('Редактировать мероприятие') }}</h2>
        <form method="POST" action="{{ route('moderator.events.update', $event->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Название *') }}</label>
                <input type="text" name="title" value="{{ old('title',$event->title) }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Описание *') }}</label>
                <textarea name="description" rows="3" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">{{ old('description',$event->description) }}</textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Дата и время *') }}</label>
                <input type="datetime-local" name="date" value="{{ old('date',$event->date->format('Y-m-d\TH:i')) }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Место / Ссылка') }}</label>
                <input type="text" name="location" value="{{ old('location',$event->location) }}" placeholder="Zoom / Алматы / Онлайн" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Тип *') }}</label>
                <select name="type" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
                    <option value="webinar" {{ $event->type==='webinar'?'selected':'' }}>🌐 Вебинар</option>
                    <option value="workshop" {{ $event->type==='workshop'?'selected':'' }}>🛠 Мастер-класс</option>
                    <option value="meeting" {{ $event->type==='meeting'?'selected':'' }}>👥 Встреча</option>
                </select>
            </div>
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-gradient">{{ __('Обновить') }}</button>
                <a href="{{ route('moderator.events.index') }}" style="padding:12px 25px; background:#f1f5f9; border-radius:8px; text-decoration:none; color:#333; font-weight:700;">{{ __('Отмена') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection