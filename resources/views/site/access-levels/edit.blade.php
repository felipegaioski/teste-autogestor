@extends('site.layout')

@section('content')
    <main>
        <div class="main-container">
            <div>
                @include('site.access-levels.header')
            </div>
            <div class="inner-container flex-column justify-content-center align-items-center">
                <div class="my-2">
                    <span>Editando o nível de acesso "{{ old('name', $access_level->name) }}"</span>
                </div>
                <div class="form-container">
                    <form action="{{ url('/niveis-de-acesso/' . $access_level->id . '/editar') }}" method="POST">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $access_level->name) }}" 
                                   placeholder="Digite o nome do nível de acesso">
                        </div>
                        <div>
                            <span class="fw-bold">Permissões</span>
                        </div>
                        @foreach($permission_categories as $category)
                        <div class="form-group mb-2">
                            <label for="name">{{  $category->name }}</label>
                            <div class="form-check d-flex row">
                                @foreach($access_level->permissions as $permission)
                                @if($permission->category->id == $category->id)
                                    <div class="col-6">
                                        <input 
                                            class="form-check-input permission-checkbox" 
                                            type="checkbox" 
                                            id="{{ $permission->name }}" 
                                            name="permissions[{{ $permission->id }}][allow]" 
                                            value="{{ $permission->pivot->allow ? '1' : '0' }}"
                                            {{ $permission->pivot->allow ? 'checked' : '' }}
                                            data-permission-id="{{ $permission->id }}"
                                        >
                                        <label class="form-check-label" for="{{ $permission->name }}">
                                            {{ $permission->name }}
                                        </label>
                                        <input type="hidden" name="permissions[{{ $permission->id }}][allow]" value="0" class="hidden-permission-input">
                                    </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group mb-2">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
    
            checkboxes.forEach(checkbox => {
                const permissionId = checkbox.dataset.permissionId;
                const hiddenInput = document.querySelector(`input[name="permissions[${permissionId}][allow]"][type="hidden"]`);
    
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        this.value = '1';
                        hiddenInput.value = '1';
                    } else {
                        this.value = '0';
                        hiddenInput.value = '0';
                    }
                });
            });
        });
    </script>
@endsection
