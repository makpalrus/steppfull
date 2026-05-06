@extends('layouts.app')
@section('title', __('О нас'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:60px 20px; color:white;">
<div style="max-width:900px; margin:0 auto; text-align:center;">
<h1 style="font-size:2.8rem;">{{ __('О нас') }}</h1>
<p style="font-size:1.3rem; margin:30px 0; line-height:1.8;">{{ __('StepUp — платформа, созданная для помощи студентам Казахстана в поиске работы и развитии карьеры.') }}</p>
<h2 style="margin-top:50px;">{{ __('Наша цель') }}</h2>
<p style="font-size:1.2rem;">{{ __('Сделать переход от университета к первой работе максимально простым и успешным.') }}</p>
</div>
</div>
@endsection