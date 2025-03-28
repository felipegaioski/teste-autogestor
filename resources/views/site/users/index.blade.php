@php
    $category_type = 'users'
@endphp

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
                    <div class="name-container col-3">
                        <span class="m-0">Nome</span>
                    </div>
                    <div class="email-container col-3">
                        <span class="m-0">E-mail</span>
                    </div>
                    <div class="email-container col-2">
                        <span class="m-0">Nível de Acesso</span>
                    </div>
                    <div class="date-container col-1">
                        <span class="m-0">Data de Criação</span>
                    </div>
                    <div class="date-container col-2">
                    </div>
                </div>
                @foreach($users as $index => $_user)
                    <div class="list-item-container row">
                        <div class="id-container col-1">
                            <span class="m-0">#{{ $_user->id }}</span>
                        </div>
                        <div class="name-container col-3">
                            <span class="m-0">{{ $_user->name }}</span>
                        </div>
                        <div class="email-container col-3">
                            <span class="m-0">{{ $_user->email }}</span>
                        </div>
                        <div class="email-container col-2">
                            <span class="m-0">{{ $_user->access_level->name }}</span>
                        </div>
                        <div class="date-container col-1">
                            <span class="m-0">{{ date('d/m/Y', strtotime($_user->created_at)) }}</span>
                        </div>
                        <div class="date-container col-2 d-flex gap-2 justify-content-end">
                            @php
                                $canEdit = false;
                                foreach ($user->access_level->permissions as $permission) {
                                    if (($permission->type === 'manage' && $user->access_level->permissions->contains($permission->id) && $permission->pivot->allow
                                    && $permission->category->type == $category_type)
                                    || $user->access_level_id == 1) {
                                        $canEdit = true;
                                        break;
                                    }
                                }
                            @endphp
                            @if ($canEdit)
                            <a href="{{ url('usuarios/' . $_user->id . '/editar') }}">
                                <button class="btn btn-primary">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </a>
                            <form action="{{ url('usuarios/' . $_user->id . '/excluir') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            {{-- <button class="btn btn-danger" 
                                    data-bs-toggle="popover" 
                                    data-bs-placement="top" 
                                    data-bs-html="true"
                                    data-bs-trigger="focus"
                                    data-bs-content-id="popover-content">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            <div class="d-none" id="popover-content">
                                <button class="btn btn-success" onclick="confirmDeleteUser(event, \'{{ url('usuarios/' . $_user->id . '/excluir') }}\')">Confirmar</button> <button class="btn btn-secondary" onclick="hidePopover()">Cancelar</button>
                            </div> --}}
                            @endif
                        </div>
                    </div>
                    @if ($users->count() > 1 && $index < $users->count() - 1)
                    <hr class="m-0">
                    @endif
                @endforeach
            </div>
        </div>
    </main>
    {{-- <script>
                document.addEventListener('DOMContentLoaded', function () {
            // Inicializa os popovers da página
            var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            
            popoverTriggerList.forEach(function (popoverTriggerEl) {
                // Para cada botão, inicialize o popover
                var popover = new bootstrap.Popover(popoverTriggerEl, {
                    content: function () {
                        // Recupera o conteúdo do popover a partir do elemento com o ID especificado
                        var contentId = popoverTriggerEl.getAttribute('data-bs-content-id');
                        var contentElement = document.getElementById(contentId);
                        return contentElement ? contentElement.innerHTML : '';
                    }
                });
            });
        });

        // Função que será chamada quando o popover for clicado
        function confirmDeleteUser(event, url) {
            // Previne o comportamento padrão do link
            event.preventDefault();

            // Mostra uma confirmação antes de excluir
            if (confirm("Você tem certeza que deseja excluir este usuário?")) {
                // Se confirmado, redireciona para a URL de exclusão
                window.location.href = url;
            }
        }

        // Função para esconder o popover
        function hidePopover() {
            var popover = bootstrap.Popover.getInstance(document.querySelector('[data-bs-toggle="popover"]'));
            if (popover) {
                popover.hide();
            }
        }

    </script> --}}
    
    
@endsection