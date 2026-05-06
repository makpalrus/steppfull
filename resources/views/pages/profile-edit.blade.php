@extends('layouts.app')
@section('title', __('Редактировать профиль'))
@section('content')
<div class="container" style="background:#1e1e2f; min-height:80vh; padding:40px 20px; color:white;">
    <div style="background:white; max-width:550px; margin:0 auto; padding:35px; border-radius:20px;">
        <h2 style="color:#1e1e2f; text-align:center; margin-bottom:30px;">{{ __('Редактировать профиль') }}</h2>

        @if($errors->any())
        <div style="background:#fee2e2; color:#dc2626; padding:12px; border-radius:8px; margin-bottom:20px; font-size:14px;">
            @foreach($errors->all() as $error) <div>⚠️ {{ $error }}</div> @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div style="margin-bottom:20px;">
                <label style="color:#1e1e2f; font-weight:600; display:block; margin-bottom:6px;">{{ __('Имя') }}</label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required 
                       style="width:100%; padding:12px; border-radius:10px; border:1px solid #ddd; font-size:15px;">
            </div>

            <div style="margin-bottom:20px;">
                <label style="color:#1e1e2f; font-weight:600; display:block; margin-bottom:6px;">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                       style="width:100%; padding:12px; border-radius:10px; border:1px solid #ddd; font-size:15px;">
            </div>

            {{-- ✅ Поле для года рождения (только для студентов) --}}
            @if(auth()->user()->role === 'student')
            <div style="margin-bottom:20px;">
                <label style="color:#1e1e2f; font-weight:600; display:block; margin-bottom:6px;">{{ __('Год рождения') }}</label>
                <input type="number" name="birth_year" 
                       value="{{ old('birth_year', auth()->user()->birth_year) }}" 
                       placeholder="2000" min="1950" max="{{ date('Y') }}"
                       style="width:100%; padding:12px; border-radius:10px; border:1px solid #ddd; font-size:15px;">
            </div>

            <div style="margin-bottom:25px; padding-top:20px; border-top:1px solid #eee;">
                <label style="color:#1e1e2f; font-weight:600; display:block; margin-bottom:6px;">📄 {{ __('Загрузить резюме') }}</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx" 
                       style="width:100%; padding:10px; border-radius:10px; border:1px solid #ddd; background:#f8f9fa;">
                <p style="color:#888; font-size:12px; margin-top:5px;">{{ __('Форматы: PDF, DOC, DOCX (макс. 2MB)') }}</p>
                
                @if(auth()->user()->resume_path)
                <div style="margin-top:10px; padding:10px; background:#d4edda; border-radius:8px; color:#155724; font-size:13px;">
                    ✅ {{ __('Резюме загружено') }}
                </div>
                @endif
            </div>
            @endif

            <div style="display:flex; gap:12px; margin-top:10px;">
                <button type="submit" 
                        style="flex:1; padding:14px; background:linear-gradient(135deg,#FF6B47,#F5A623); color:white; border:none; border-radius:12px; font-weight:700; cursor:pointer; font-size:15px;">
                    SAVE
                </button>
                <a href="{{ route('profile') }}" 
                   style="flex:1; padding:14px; background:#f1f5f9; color:#475569; border-radius:12px; text-align:center; text-decoration:none; font-weight:700; font-size:15px;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection