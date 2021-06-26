@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCreate">Create</button>
                <div class="card">
                    <table class="table display compact" id="user_table" style="width:100%">
                        <thead>
                        <th>Usuarios</th>
                        <th>Correo</th>
                        <th colspan="">Acción</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreate" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="create">
                            <label for="formGroupExampleInput">Nombre (*)</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" required >

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalupdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formUpdate" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <input type="hidden" name="id" id="id">
                            <label for="formGroupExampleInput">Nombre (*)</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="formGroupExampleInput">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" required >

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <script>
        let url_users = "{{route('users')}}";
        $(document).ready( function () {
           table = $('#user_table').DataTable({

                "ajax": url_users,
                "columns": [
                    {
                        data: 'name', "render": function (data, type, row, meta) {
                            return '<a href="#" class="btn btn-info btn-sm edit" data-id="'+row.id+'">' + row.name + '</a>'
                        }
                    },
                    {data: 'email'},
                    {data: 'id', render: function (data, type, row, meta) {
                        return '<form method="POST" action="' + `${url_users}/${row.id}` + '" accept-charset="UTF-8">' +
                            '<input name="_method" type="hidden" value="DELETE">' +
                            '<input name="_token" type="hidden" value="' + window.token.csrfToken + '">' +

                            '<div class="btn-group">' +
                            '<button type="submit" class="btn btn-warning btn-xs">Eliminar</button>' +
                            '</div></form>';

                    }}
                ]
            });

            $('body').on('click', '.edit', function () {
                let element = $(this);
                let id = element.data('id');

                let fieldId = $("#formUpdate #id");
                let fieldName = $("#formUpdate #name");
                let fieldEmail = $("#formUpdate #email");
                $.get(`/user/${id}`, ({id,name, email}) => {
                    fieldId.val(id);
                    fieldName.val(name);
                    fieldEmail.val(email);
                    $("#modalupdate").modal('show');
                });
            });

            $("#formCreate").on('submit', function(e) {
                e.preventDefault();
                let data = $(this).serializeArray()
                $.post(url_users, data, (response) => {
                    table.ajax.reload();
                    $("#modalCreate").modal('hide');
                }) .fail(function(response) {
                    let message = '';
                    $.each(response.responseJSON.errors, function(i,e){
                        message += `${e} \n`;
                    })
                    alert(message)
                    $("#modalCreate").modal('hide');
                })
            });

            $("#formUpdate").on('submit', function(e) {
                e.preventDefault();
                let fieldId = $("#formUpdate #id").val();
                let data = $(this).serializeArray();
                console.log(data);
                data.push({name: '_method', value: 'PUT'});
                $.post(`${url_users}/${fieldId}`, data, (response) => {
                    table.ajax.reload();
                    $("#modalupdate").modal('hide');
                }) .fail(function(response) {
                    let message = '';
                    $.each(response.responseJSON.errors, function(i,e){
                        message += `${e} \n`;
                    })
                    alert(message)
                    $("#modalupdate").modal('hide');
                })
            });
        } );


    </script>
@endsection
