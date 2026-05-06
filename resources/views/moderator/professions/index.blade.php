@extends('layouts.app')
@section('title', __('Управление профессиями'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 style="color:white;">{{ __('Профессии') }}</h1>
        <a href="{{ route('moderator.professions.create') }}" class="btn-gradient">+ {{ __('Добавить') }}</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div style="background:white; border-radius:15px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:#1e1e2f; color:white;">
                <tr><th style="padding:12px 15px; text-align:left;">Название</th><th style="padding:12px 15px; text-align:left;">Зарплата</th><th style="padding:12px 15px;">Действия</th></tr>
            </thead>
            <tbody>
                @forelse($professions as $p)
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:12px 15px;">{{ $p->icon ?? '💼' }} {{ $p->title }}</td>
                    <td style="padding:12px 15px;">{{ $p->salary_range ?? '—' }}</td>
                    <td style="padding:12px 15px; text-align:right;">
                        <a href="{{ route('moderator.professions.edit', $p->id) }}" style="color:#FF6B47; margin-right:10px;">✏️</a>
                        <form method="POST" action="{{ route('moderator.professions.destroy', $p->id) }}" style="display:inline;" onsubmit="return confirm('Удалить?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;">🗑</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="padding:20px; text-align:center; color:#888;">{{ __('Нет профессий') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $professions->links() }}</div>
</div>
@endsection