@extends('layouts.app')
@section('title', __('Управление мероприятиями'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:30px;">
        <h1 style="color:white;">{{ __('Мероприятия') }}</h1>
        <a href="{{ route('moderator.events.create') }}" class="btn-gradient">+ {{ __('Добавить') }}</a>
    </div>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div style="background:white; border-radius:15px; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:#1e1e2f; color:white;">
                <tr><th style="padding:12px 15px; text-align:left;">Название</th><th style="padding:12px 15px; text-align:left;">Дата</th><th style="padding:12px 15px; text-align:left;">Тип</th><th style="padding:12px 15px;">Действия</th></tr>
            </thead>
            <tbody>
                @forelse($events as $e)
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:12px 15px;">{{ $e->title }}</td>
                    <td style="padding:12px 15px;">{{ \Carbon\Carbon::parse($e->date)->format('d.m.Y') }}</td>
                    <td style="padding:12px 15px;">{{ $e->type }}</td>
                    <td style="padding:12px 15px; text-align:right;">
                        <a href="{{ route('moderator.events.edit', $e->id) }}" style="color:#FF6B47; margin-right:10px;">✏️</a>
                        <form method="POST" action="{{ route('moderator.events.destroy', $e->id) }}" style="display:inline;" onsubmit="return confirm('Удалить?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;">🗑</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding:20px; text-align:center; color:#888;">{{ __('Нет мероприятий') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px;">{{ $events->links() }}</div>
</div>
@endsection