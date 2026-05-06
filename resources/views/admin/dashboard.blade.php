@extends('layouts.app')
@section('title', __('Панель администратора'))
@section('content')
<div class="container" style="background:#1e1e2f;min-height:80vh;padding:40px 20px;">
    <h2 class="section-title" style="color:white;text-align:center;margin-bottom:40px;">{{ __('Панель администратора') }}</h2>
    
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:20px;margin-bottom:40px;">
        @foreach([['👥', __('Пользователей'), $stats['total_users']], ['📋', __('Вакансий'), $stats['total_vacancies']], ['⏳', __('На модерации'), $stats['pending']], ['✅', __('Одобрено'), $stats['approved']]] as [$icon, $label, $val])
        <div style="background:white;border-radius:15px;padding:20px;text-align:center;">
            <div style="font-size:28px">{{ $icon }}</div>
            <div style="font-size:28px;font-weight:700;color:#FF6B47">{{ $val }}</div>
            <div style="font-size:13px;color:#888">{{ $label }}</div>
        </div>
        @endforeach
    </div>

    <h3 style="color:white;margin-bottom:15px;">{{ __('Вакансии на модерации') }}</h3>
    <div style="background:white;border-radius:15px;overflow:hidden;margin-bottom:40px;">
        <table style="width:100%;border-collapse:collapse">
            <thead style="background:linear-gradient(135deg,#FF6B47,#F5A623)">
                <tr style="color:white;font-size:13px">
                    <th style="padding:12px 15px;text-align:left">{{ __('Вакансия') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Компания') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Автор') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Статус') }}</th>
                    <th style="padding:12px 15px">{{ __('Действия') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vacancies->where('status', 'pending') as $v)
                <tr style="border-bottom:1px solid #eee;font-size:13px">
                    <td style="padding:12px 15px">{{ $v->title }}</td>
                    <td style="padding:12px 15px">{{ $v->company }}</td>
                    <td style="padding:12px 15px">{{ $v->user->name ?? '—' }}</td>
                    <td style="padding:12px 15px"><span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#fff3cd;color:#856404">⏳ {{ __('На модерации') }}</span></td>
                    <td style="padding:12px 15px;text-align:center;display:flex;gap:8px;justify-content:center">
                        <a href="/vacancies/{{ $v->id }}/edit" style="color:#FF6B47;font-size:12px;text-decoration:none;font-weight:700">✏️ {{ __('Изменить') }}</a>
                        <form method="POST" action="/vacancies/{{ $v->id }}" onsubmit="return confirm('{{ __('Удалить вакансию?') }}')" style="display:inline">@csrf @method('DELETE')<button style="background:none;border:none;color:#999;cursor:pointer;font-size:12px">🗑 {{ __('Удалить') }}</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:20px;text-align:center;color:#888">{{ __('Нет вакансий на модерации') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h3 style="color:white;margin-bottom:15px;">{{ __('Управление пользователями') }}</h3>
    <div style="background:white;border-radius:15px;overflow:hidden;">
        <table style="width:100%;border-collapse:collapse">
            <thead style="background:#1e1e2f">
                <tr style="color:white;font-size:13px">
                    <th style="padding:12px 15px;text-align:left">ID</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Имя') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Email') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Роль') }}</th>
                    <th style="padding:12px 15px;text-align:left">{{ __('Статус') }}</th>
                    <th style="padding:12px 15px">{{ __('Действия') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr style="border-bottom:1px solid #f0f0f0;font-size:13px; {{ $u->is_banned ? 'opacity:0.6' : '' }}">
                    <td style="padding:12px 15px;color:#888">{{ $u->id }}</td>
                    <td style="padding:12px 15px;font-weight:700">{{ $u->name }}</td>
                    <td style="padding:12px 15px;color:#555">{{ $u->email }}</td>
                    <td style="padding:12px 15px">
                        @if(auth()->id() !== $u->id)
                        <form method="POST" action="{{ route('admin.users.role', $u->id) }}" style="display:inline;">
                            @csrf
                            <select name="role" onchange="this.form.submit()" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:11px;">
                                <option value="student" {{ $u->role==='student'?'selected':'' }}>🎓 Student</option>
                                <option value="employer" {{ $u->role==='employer'?'selected':'' }}>🏢 Employer</option>
                                <option value="moderator" {{ $u->role==='moderator'?'selected':'' }}>🛡 Moderator</option>
                                <option value="admin" {{ $u->role==='admin'?'selected':'' }}>👑 Admin</option>
                            </select>
                        </form>
                        @else
                        <span style="font-size:11px; color:#888;">{{ __('Вы') }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 15px">
                        @if($u->is_banned)
                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#f8d7da;color:#721c24">❌ {{ __('Забанен') }}</span>
                        @else
                        <span style="padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:#d4edda;color:#155724">✅ {{ __('Активен') }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 15px;text-align:right">
                        @if(auth()->id() !== $u->id)
                        <form method="POST" action="{{ route('admin.users.ban', $u->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:{{ $u->is_banned ? '#28a745' : '#dc3545' }};cursor:pointer;font-size:12px;font-weight:700;">
                                {{ $u->is_banned ? '🔓 '.__('Разбанить') : '🔒 '.__('Забанить') }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('{{ __('Удалить пользователя?') }}')" style="display:inline;margin-left:10px;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none;border:none;color:#999;cursor:pointer;font-size:12px;">🗑</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection