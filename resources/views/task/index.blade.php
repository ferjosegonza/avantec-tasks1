<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.0/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="nav-link" href="https://www.avantecds.com/">
                <img src="{{ asset('images/avantec-2023.png') }}" alt="Avantec Logo" style="height: 50px; margin-right: 5px;">
                Sistema de Gestión de Tareas para Avantec.ds
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<div class="container" style="width: 90%">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab">
            <div style="display:flex; justify-content: space-between;">
                <h4>Lista de Tareas</h4>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tareaModal">
                    Nueva Tarea
                </button>
            </div>
            <table id="tabla-task" class="table table-hover">
                <thead>
                    <td>ID</td>
                    <td>USER ID</td>
                    <td>TITLE</td>
                    <td>DESCRIPTION</td>
                    <td>COMPLETED</td>
                    <td>CREATED AT</td>
                    <td>UPDATED AT</td>
                    <td>ACCIONES</td>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal para crear una nueva tarea -->
<div class="modal fade" id="tareaModal" tabindex="-1" aria-labelledby="tareaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registro-task">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selUsuario">Usuario</label>
                        <select class="form-control" id="selUsuario">
                            <option value="1">fer</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputTitle">Title</label>
                        <input type="text" class="form-control" id="inputTitle" placeholder="Escribe el título de la tarea">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Description</label>
                        <input type="text" class="form-control" id="inputDescription" placeholder="Escribe la descripción de la tarea">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="checkCompleted">
                        <label class="form-check-label" for="checkCompleted">Completed</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para q el usuario confirme q desea eliminar el registro de una tarea -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Por favor confirme que desea eliminar la tarea seleccionada.</h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-danger" name="btnEliminar" id="btnEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para modificar una tarea -->
<div class="modal fade" id="modificarTareaModal" tabindex="-1" aria-labelledby="modificarTareaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editar-task-form">
                <input type="hidden" name="editar-id" id="editar-id">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selUsuario">Usuario</label>
                        <select class="form-control" id="editar-selUsuario">
                            <option value="1">fer</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="inputTitle">Title</label>
                        <input type="text" class="form-control" id="editar-inputTitle" placeholder="Escribe el título de la tarea">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Description</label>
                        <input type="text" class="form-control" id="editar-inputDescription" placeholder="Escribe la descripción de la tarea">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="editar-checkCompleted">
                        <label class="form-check-label" for="checkCompleted">Completed</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

// Listar tareas con DataTable
$(document).ready(function () {
    var tablaTask = $('#tabla-task').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
            url: "{{ route('task.index')}}",
        },
        columns:[
            {data: 'id'},
            {data: 'user_id'},
            {data: 'title'},
            {data: 'description'},
            {data: 'completed'},
            {data: 'created_at'},
            {data: 'updated_at'},
            {data: 'action', orderable: false}
        ]
    });
});

// Registra nueva tarea
$('#registro-task').submit(function (e) {
    e.preventDefault();

    var user_id =$('#selUsuario').val();
    var title =$('#inputTitle').val();
    var description =$('#inputDescription').val();
    var booleanCompleted =$('#checkCompleted').is(':checked');
    var completed = booleanCompleted ? 1 : 0;
    var _token = $("input[name=_token]").val();

    $.ajax({
        url: "{{ route('task.registrar')}}",
        type: "POST",
        data:{
            user_id: user_id,
            title: title,
            description: description,
            completed: completed,
            _token: _token
        },
        success:function(response) {
            if (response){
                $('#registro-task')[0].reset();
                toastr.success('La tarea se registro correctamente.', 'Nuevo Registro', {timeOut:3000});
                $('#tabla-task').DataTable().ajax.reload();
                $('#tareaModal').modal('hide');
            }
        }
    });
});

// Eliminar una tarea
var task_id;
$(document).on('click', '.delete', function() {
    task_id = $(this). attr('id');
    $('#confirmModal').modal('show');
});

$('#btnEliminar').click(function() {
    $.ajax({
        url:"task/eliminar/"+task_id,
        beforeSend:function() {
            $('#btnEliminar').text('Eliminando...');
        },
        success:function(data){
            setTimeout(function() {
                toastr.warning('La tarea fue eliminado correctamente.', 'Eliminar Registro', {timeOut:3000});
                $('#tabla-task').DataTable().ajax.reload();
                $('#confirmModal').modal('hide');
            }, 2000);
            $('#btnEliminar').text('Eliminar');
        }
    });
});

// Mostrar los datos de la tarea a Editar
function editarTask(id) {
    $.get('task/editar/'+id, function(task) {
        // asignar los datos recuperados a la ventana modal
        $('#modificarTareaModal').modal('toggle');

        $('#editar-id').val(task[0].id);
        $('#editar-selUsuario').val(task[0].user_id);
        $('#editar-inputTitle').val(task[0].title);
        $('#editar-inputDescription').val(task[0].description);
        $('#editar-checkCompleted').prop('checked', task[0].completed);
        $("input[name=_token]").val();
    });
}

// Actualizar los cambios de la tarea en la Base de Datos
$('#editar-task-form').submit(function (e) {
    e.preventDefault();

    var id_upd =$('#editar-id').val();
    var user_id_upd =$('#editar-selUsuario').val();
    var title_upd =$('#editar-inputTitle').val();
    var description_upd =$('#editar-inputDescription').val();
    var booleanCompleted_upd =$('#editar-checkCompleted').is(':checked');
    var completed_upd = booleanCompleted_upd ? 1 : 0;
    var _token_upd = $("input[name=_token]").val();

    $.ajax({
        url: "{{ route('task.actualizar') }}",
        type: "POST",
        data:{
            id: id_upd,
            user_id: user_id_upd,
            title: title_upd,
            description: description_upd,
            completed: completed_upd,
            _token: _token_upd
        },
        success:function(response) {
            if (response){
                //$('#editar-task-form')[0].reset();
                //$('#editar-task-form').modal('hide');
                toastr.info('La tarea fue modificada correctamente.', 'Actualizar Registro', {timeOut:3000});
                $('#tabla-task').DataTable().ajax.reload();
                $('#modificarTareaModal').modal('hide');
            }
        }
    });
});
</script>
</body>
</html>