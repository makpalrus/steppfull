@extends('layouts.app')
@section('title', __('Контакты и помощь'))
@section('content')
<div class="container" style="padding:60px 20px;">
<h1 style="text-align:center;">{{ __('Контакты и помощь') }}</h1>
<div style="max-width:800px; margin:50px auto;">
<h2>{{ __('Часто задаваемые вопросы') }}</h2>
<p>{{ __('1. Как откликнуться?') }} → {{ __('Зарегистрируйтесь как студент и нажмите кнопку "Откликнуться".') }}</p>
<p>{{ __('2. Кто видит мои данные?') }} → {{ __('Только работодатель, разместивший вакансию.') }}</p>
<h2 style="margin-top:50px;">{{ __('Напишите нам') }}</h2>
<form method="POST" action="/contact">
@csrf
<textarea name="message" rows="7" class="form-control" placeholder="{{ __('Ваше сообщение...') }}"></textarea><br>
<button type="submit" class="btn-gradient">{{ __('Отправить') }}</button>
</form>
</div>
</div>
@endsection