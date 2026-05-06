@extends('layouts.app')
@section('title', __('Управление тестами'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px;">
    <h1 style="color:white; margin-bottom:30px;">{{ __('Тесты на профориентацию') }}</h1>
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    <div style="background:white; border-radius:15px; padding:25px;">
        <p style="color:#666; margin-bottom:20px;">{{ __('Тесты — это внешние ссылки. Модератор может управлять списком доступных тестов.') }}</p>
        <table style="width:100%; border-collapse:collapse;">
            <thead style="background:#1e1e2f; color:white;">
                <tr><th style="padding:12px 15px; text-align:left;">Название</th><th style="padding:12px 15px; text-align:left;">Ссылка</th><th style="padding:12px 15px;">Статус</th><th style="padding:12px 15px;">Действия</th></tr>
            </thead>
            <tbody>
                @foreach($tests as $t)
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:12px 15px;">{{ $t['title'] }}</td>
                    <td style="padding:12px 15px;"><a href="{{ $t['url'] }}" target="_blank" style="color:#FF6B47;">{{ Str::limit($t['url'],40) }}</a></td>
                    <td style="padding:12px 15px;"><span style="color:#28a745; font-weight:700;">✅ Активен</span></td>
                    <td style="padding:12px 15px; text-align:right;">
                        <form method="POST" action="{{ route('moderator.tests.destroy', $t['id']) }}" style="display:inline;" onsubmit="return confirm('Скрыть тест?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; color:#dc3545; cursor:pointer;">🗑 Скрыть</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection