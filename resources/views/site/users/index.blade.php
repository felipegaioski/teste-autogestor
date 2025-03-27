@extends('site.layout')

@section('content')
    <main>
        <div class="main-container">
            @include('site.users.header')
            <div class="list-container">
                <div class="list-header row m-0">
                    <div class="id-container col-1">
                        <span class="m-0">ID</span>
                    </div>
                    <div class="name-container col-4">
                        <span class="m-0">Nome</span>
                    </div>
                    <div class="email-container col-4">
                        <span class="m-0">E-mail</span>
                    </div>
                    <div class="date-container col-3">
                        <span class="m-0">Data de Criação</span>
                    </div>
                </div>
                @foreach($users as $index => $user)
                    <div class="list-item-container row">
                        <div class="id-container col-1">
                            <span class="m-0">#{{ $user->id }}</span>
                        </div>
                        <div class="name-container col-4">
                            <span class="m-0">{{ $user->name }}</span>
                        </div>
                        <div class="email-container col-4">
                            <span class="m-0">{{ $user->email }}</span>
                        </div>
                        <div class="date-container col-3">
                            <span class="m-0">{{ date('d/m/Y', strtotime($user->created_at)) }}</span>
                        </div>
                    </div>
                    @if ($users->count() > 1 && $index < $users->count() - 1)
                    <hr class="m-0">
                    @endif
                @endforeach
            </div>
        </div>
    </main>
@endsection