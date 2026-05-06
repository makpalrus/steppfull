@extends('layouts.app')
@section('title', __('Редактировать профессию'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="background:white; max-width:600px; margin:0 auto; padding:30px; border-radius:15px;">
        <h2 style="color:#1e1e2f; margin-bottom:20px;">{{ __('Редактировать профессию') }}</h2>
        <form method="POST" action="{{ route('moderator.professions.update', $profession->id) }}">
            @csrf @method('PUT')
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Название *') }}</label>
                <input type="text" name="title" value="{{ old('title',$profession->title) }}" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Описание *') }}</label>
                <textarea name="description" rows="4" required style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">{{ old('description',$profession->description) }}</textarea>
            </div>
            <div style="margin-bottom:15px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Зарплата') }}</label>
                <input type="text" name="salary_range" value="{{ old('salary_range',$profession->salary_range) }}" placeholder="400 000 — 1 200 000 ₸" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block; margin-bottom:5px; font-weight:700;">{{ __('Иконка (эмодзи)') }}</label>
                <input type="text" name="icon" value="{{ old('icon',$profession->icon) }}" placeholder="💻" maxlength="10" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;">
            </div>
            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-gradient">{{ __('Обновить') }}</button>
                <a href="{{ route('moderator.professions.index') }}" style="padding:12px 25px; background:#f1f5f9; border-radius:8px; text-decoration:none; color:#333; font-weight:700;">{{ __('Отмена') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection