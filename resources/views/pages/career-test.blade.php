@extends('layouts.app')
@section('title', __('Тест на профессию'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:50px 20px; color:white; text-align:center;">
    <h1 style="margin-bottom:15px;">{{ __('Тесты на профориентацию') }}</h1>
    <p style="font-size:1.2rem; max-width:650px; margin:0 auto 40px; opacity:0.9;">
        {{ __('Выбери подходящий тест. Все ссылки ведут на проверенные внешние платформы.') }}
    </p>
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:25px; max-width:1000px; margin:0 auto;">
        @php $tests = \App\Models\Profession::all()->isEmpty() ? [
            ['title'=>'Типология Голланда','url'=>'https://trud.com/kz/test'],
            ['title'=>'Профессии для студентов','url'=>'https://proforientator.ru/tests'],
            ['title'=>'Soft Skills','url'=>'https://www.16personalities.com/ru'],
            ['title'=>'Тест для студентов KZ','url'=>'https://enbek.kz/ru/career-guidance'],
        ] : []; @endphp
        @foreach($tests as $test)
        <div style="background:white; color:#1e1e2f; border-radius:15px; padding:25px; text-align:left;">
            <h3 style="color:#FF6B47; margin:0 0 10px;">{{ $test['title'] }}</h3>
            <a href="{{ $test['url'] }}" target="_blank" rel="noopener" class="btn-gradient" style="width:100%; text-align:center; display:block;">
                {{ __('Пройти тест →') }}
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection