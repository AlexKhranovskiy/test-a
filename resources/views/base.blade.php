<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Users</title>

    <!-- Styles -->
    <style>
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css"/>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body>
<div class="alert alert-success collapse" role="alert" id="alertSuccess">
    This is a success alert with <a href="#" class="alert-link">an example link</a>. Give it a click if you like.
</div>
<table id="myTable" class="table">
    <thead>
    <tr>
        <th scope="col">
            <button type="button" id="registerButton" class="btn btn-secondary btn-sm">Register</button>
        </th>
        <th scope="col">Name</th>
        <th scope="col">E-mail</th>
        <th scope="col">Phone</th>
        <th scope="col">Position</th>
        <th scope="col">Position_id</th>
        <th scope="col">Registration_timestamp</th>
        <th scope="col">Photo</th>
    </tr>
    </thead>
    <tbody>
    {{--    @foreach($categories as $category)--}}
    {{--        <tr>--}}
    {{--            <th scope="row">--}}
    {{--                <button type="button" class="btn btn-secondary btn-sm"--}}
    {{--                        onclick="myShowModal({{$category->id}})">{{$category->id}}</button>--}}
    {{--            </th>--}}
    {{--            <td>{{$category->name}}</td>--}}
    {{--            <td>{{$category->created_at}}</td>--}}
    {{--            <td>{{$category->updated_at}}</td>--}}
    {{--        </tr>--}}
    {{--    @endforeach--}}
    </tbody>
</table>
<button type="button" id="showMoreUsersButton" class="btn btn-secondary btn-sm">Show more</button>
{{--<button id="button1"> 1</button>--}}
{{--<button id="button2"> 2</button>--}}
{{--<button id="button3"> 3</button>--}}
<!-- Modal for create-->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Register user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="inputRegisterUserName">Name:</label>
                <input id="inputRegisterUserName" name="name" type="text"/><br/>
                <label for="inputRegisterUserEmail">E-mail:</label>
                <input id="inputRegisterUserEmail" name="email" type="text"/><br/>
                <label for="inputRegisterUserPhone">Phone:</label>
                <input id="inputRegisterUserPhone" name="phone" type="text"/><br/>
                {{--                <label for="inputRegisterUserPositionId">Position_id:</label>--}}
                {{--                <input id="inputRegisterUserPositionId" name="position_id" type="text"/><br/>--}}
                <label for="positionSelect">Position:
                    <select id="positionSelect"></select>
                </label><br/>
                <label for="inputRegisterUserPhoto">Photo:</label>
                <input id="inputRegisterUserPhoto" name="photo" type="file"/><br/>
            </div>
            <div class="modal-footer">
                <button id="closeRegisterUserButton" type="button" class="btn btn-secondary btn-sm"
                        data-dismiss="modal">Close
                </button>
                {{--                <button id="button11" type="button" class="btn btn-secondary btn-sm">11</button>--}}
                <button id="saveChangesRegisterUserButton" type="button" class="btn btn-primary btn-sm">Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for edit-->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="inputEditCategoryName" id="inputEditCategoryId"></label>
                <input id="inputEditCategoryName" name="categoryName" type="text"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" id="saveChangesEditCategoryButton" class="btn btn-primary btn-sm">Save changes
                </button>
                <button type="button" id="deleteCategoryButton"
                        class="btn btn-danger btn-sm" data-id="">Delete
                </button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script defer>
    let token;
    let page = 1;

    function showRegisterModal() {
        $("#registerUserModal").modal();
        getPositions(token);
    }

    {{--function showEditModal(categoryId) {--}}
    {{--    let url = '{{route('users.show', '')}}' + '/' + categoryId;--}}
    {{--    $('#deleteCategoryButton').val(categoryId);--}}
    {{--    $.ajax({--}}
    {{--        method: "get",--}}
    {{--        url: url,--}}
    {{--        success: function (response) {--}}
    {{--            $("#inputEditCategoryId").text(response.id).val(response.id);--}}
    {{--            $("#inputEditCategoryName").val(response.name);--}}
    {{--            $("#editModal").modal();--}}
    {{--        }--}}
    {{--    });--}}
    {{--}--}}

    // $(document).ready(function () {
    getToken(function (result) {
        token = result;
    });

    loadTable(token);
    //table.data = load();
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });


    $('#registerButton').click(function () {
        showRegisterModal();
    });

    $('#showMoreUsersButton').click(function () {
        showMoreUsers(token);
    });

    // $('#button2').click(function () {
    //     console.log(token);
    // });
    //
    // $('#button3').click(function () {
    //     getResult(function (result) {
    //         token = result;
    //     })
    // });


    // $.ajax({
    //     url : 'upload.php',
    //     type : 'POST',
    //     data : formData,
    //     processData: false,  // tell jQuery not to process the data
    //     contentType: false,  // tell jQuery not to set contentType
    //     success : function(data) {
    //         console.log(data);
    //         alert(data);
    //     }
    // });

    $('#saveChangesRegisterUserButton').click(function () {
        $("#registerUserModal").modal('hide');
        registerUser(token);
        emptyPositionSelect();
    });

    $('#closeRegisterUserButton').click(function () {
        emptyPositionSelect();
    });

    $('#button11').click(function () {
        $("#positionSelect").empty();
    });
    // $('body').on('click', '#deleteCategoryButton', function () {
    // }).on('click', '#saveChangesEditCategoryButton', function () {
    // }).on('click','#registerButton', function () {
    // }).on('click', '#saveChangesRegisterUserButton', function () {
    // });
    //});

    function loadTable(token) {
        let config = {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }

        fetch("{{route('users.all')}}" + "?page=" + page, config).then(function (response) {
            return response.json();
        }).then(function (data) {
            console.log(data);
            if (data.success) {
                let table = $('#myTable').DataTable({
                    stateSave: true,
                    columns: [
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'email'},
                        {data: 'phone'},
                        {data: 'position'},
                        {data: 'position_id'},
                        {data: 'registration_timestamp'},
                        {
                            data: 'photo', render: function (data, type, row) {
                                return `<img
                                    class="fit-picture"
                                    src="${data}"
                                    alt="No image" /> `;

                            }
                        }
                    ],
                });
                data.users.forEach(function (value) {
                    table.row.add(value).draw();
                });
                page++;
                return table;
            } else {
                fetch("{{route('token')}}").then(function (response) {
                    return response.json();
                }).then(function (data) {
                    console.log(data);
                    token = data.token;
                    loadTable(data.token);
                });
            }
        });
    }

    function showMoreUsers(token) {
        let config = {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }
        fetch("{{route('users.all')}}" + "?page=" + page, config).then(function (response) {
            return response.json();
        }).then(function (data) {
            if (data.success) {
                console.log(data);
                data.users.forEach(function (value) {
                    $('#myTable').DataTable().row.add(value).draw();
                });
                page++;
            } else {
                fetch("{{route('token')}}").then(function (response) {
                    return response.json();
                }).then(function (data) {
                    console.log(data);
                    token = data.token;
                    showMoreUsers(data.token);
                });
            }
        });
    }

    function getPositions(token) {
        let config = {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        }

        fetch("{{route('positions')}}", config).then(function (response) {

            return response.json();
        }).then(function (data) {
            console.log(data);
            if (data.success) {
                data.positions.forEach(function (value) {
                    $('#positionSelect').append($('<option></option>').text(value.name).attr('value', value.id));
                });
            } else {
                alert(data.message + " You have to reload the page to work with a new token.");
                {{--fetch("{{route('token')}}").then(function (response) {--}}
                {{--    return response.json();--}}
                {{--}).then(function (data) {--}}
                {{--    console.log(data);--}}
                {{--    token = data.token;--}}
                {{--    getPositions(data.token);--}}
                {{--});--}}
            }
        });

    }

    {{--function getUsers(token) {--}}
    {{--    fetch(--}}
    {{--        "{{route('token')}}", {--}}
    {{--            method: GET,--}}
    {{--            headers: {--}}
    {{--                'Authorization': 'Bearer ' + token--}}
    {{--            }--}}
    {{--        }--}}
    {{--    ).then(function (response) {--}}
    {{--        return response.json();--}}
    {{--    }).then(function (data) {--}}
    {{--        console.log(data);--}}
    {{--    });--}}
    {{--}--}}

    {{--function getResult(callback) {--}}
    {{--    fetch("{{route('token')}}").then(function (response) {--}}
    {{--        return response.json();--}}
    {{--    }).then(function (data) {--}}
    {{--        callback(data.token);--}}
    {{--    });--}}
    {{--}--}}

    function getToken(callback) {
        fetch("{{route('token')}}").then(function (response) {
            return response.json();
        }).then(function (data) {
            callback(data.token);
        });
    }

    function registerUser(token) {
        let formData = new FormData();
        formData.append('name', $("#inputRegisterUserName").val());
        formData.append('email', $("#inputRegisterUserEmail").val());
        formData.append('phone', $("#inputRegisterUserPhone").val());
        formData.append('position_id', $("#positionSelect").val());
        formData.append('photo', $('#inputRegisterUserPhoto')[0].files[0]);

        let config = {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            method: 'POST',
            body: formData
        }
        fetch("{{route('users.register')}}", config).then(function (response) {
            return response.json();
        }).then(function (data) {
            console.log(data);
            if (data.success) {
                alert(data.message);
            } else {
                alert(data.message + " You have to reload the page to work with a new token.");
            }
        });

        {{--$.ajax({--}}
        {{--    headers: {--}}
        {{--        'Authorization': 'Bearer ' + token--}}
        {{--    },--}}
        {{--    method: "post",--}}
        {{--    url: '{{route('users.register')}}',--}}
        {{--    data: formData,--}}
        {{--    processData: false,--}}
        {{--    contentType: false,--}}
        {{--    success: function (data) {--}}
        {{--        console.log(data);--}}
        {{--    },--}}
        {{--    error: function (data) {--}}
        {{--        console.log(data);--}}
        {{--        if(data.status === 401){--}}
        {{--            fetch("{{route('token')}}").then(function (response) {--}}
        {{--                return response.json();--}}
        {{--            }).then(function (data) {--}}
        {{--                console.log(data);--}}
        {{--                token = data.token;--}}
        {{--            });--}}
        {{--        }--}}
        {{--        alert(data.responseJSON.message);--}}
        {{--    }--}}
        {{--});--}}
    }

    function emptyPositionSelect() {
        $("#positionSelect").empty();
    }

    {{--function doo(){--}}
    {{--    fetch('{{route('api.category.destroy', '')}}' + '/' + '12',  {--}}
    {{--        method: 'DELETE'--}}
    {{--    });--}}
    {{--    window.table.ajax.reload();--}}
    {{--}--}}

</script>
