@extends('layouts.admin')

@section('title', 'Пользователи')

@section('content')
<div class="admin-page-title">Пользователи</div>

<table class="admin-table">
    <thead>
        <tr>
            <th>Имя</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Роль</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td style="font-weight:500">{{ $user->name }}</td>
                <td style="color:var(--text2)">{{ $user->email }}</td>
                <td style="color:var(--text2)">{{ $user->telefon ?? '—' }}</td>
                <td>
                    <span class="status-badge {{ $user->role_id == 1 ? 'status-pending' : 'status-approved' }}">
                        {{ $user->role_id == 1 ? 'Администратор' : 'Пользователь' }}
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;align-items:center">
                        {{-- CHANGE ROLE --}}
                        <form method="POST" action="{{ route('changeUser') }}" style="display:inline">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="role" value="{{ $user->role_id == 1 ? 0 : 1 }}">
                            <button type="submit" class="action-btn action-btn-green">
                                {{ $user->role_id == 1 ? 'Снять права' : 'Сделать админом' }}
                            </button>
                        </form>

                        {{-- DELETE --}}
                        <form method="POST" action="{{ route('deleteUser') }}" style="display:inline"
                              onsubmit="return confirm('Удалить пользователя «{{ $user->name }}»?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <button type="submit" class="action-btn action-btn-red">Удалить</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;color:var(--text3);padding:32px">
                    Нет пользователей
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@if($users->hasPages())
    <div class="pagination">
        @if(!$users->onFirstPage())
            <a href="{{ $users->previousPageUrl() }}" class="page-btn">←</a>
        @endif
        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-btn {{ $page == $users->currentPage() ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
        @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="page-btn">→</a>
        @endif
    </div>
@endif
@endsection
