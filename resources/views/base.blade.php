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
    </tbody>
</table>
<button type="button" id="showMoreUsersButton" class="btn btn-secondary btn-sm">Show more</button>
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
                <button id="saveChangesRegisterUserButton" type="button" class="btn btn-primary btn-sm">Save changes
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for showing user info-->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="imageUser" class="fit-picture" alt="No image"/><br/>
                <label for="inputUserId">Id:</label>
                <input id="inputUserId" name="id" type="text"/><br/>
                <label for="inputUserName">Name:</label>
                <input id="inputUserName" name="name" type="text"/><br/>
                <label for="inputUserEmail">E-mail:</label>
                <input id="inputUserEmail" name="email" type="text"/><br/>
                <label for="inputUserPhone">Phone:</label>
                <input id="inputUserPhone" name="phone" type="text"/><br/>
                <label for="inputUserPosition">Position:</label>
                <input id="inputUserPosition" name="position" type="text"/><br/>
                <label for="inputUserPositionId">Position_id:</label>
                <input id="inputUserPositionId" name="position_id" type="text"/><br/>
                <label for="inputUserPhoto">Photo:</label>
                <input id="inputUserPhoto" name="photo" type="text"/><br/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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

    function showUserModal(userId) {
        let config = {
            headers: {
                'Accept': 'application/json'
            }
        }
        fetch('{{route('users.show', '')}}' + '/' + userId, config).then(function (response) {
            console.log(response);
            return response.json();
        }).then(function (data) {
            console.log(data);
            $("#imageUser").attr('src', data.user.photo);
            $("#inputUserId").text(data.user.id).val(data.user.id);
            $("#inputUserName").text(data.user.name).val(data.user.name);
            $("#inputUserEmail").text(data.user.email).val(data.user.email);
            $("#inputUserPhone").text(data.user.phone).val(data.user.phone);
            $("#inputUserPosition").text(data.user.position).val(data.user.position);
            $("#inputUserPositionId").text(data.user.position_id).val(data.user.position_id);
            $("#inputUserPhoto").text(data.user.photo).val(data.user.photo);
            $("#userModal").modal();
        });
    }

    getToken(function (result) {
        token = result;
    });

    $(document).ready(function() {
        loadTable();
    });

    $('#registerButton').click(function () {
        showRegisterModal();
    });

    $('#showMoreUsersButton').click(function () {
        showMoreUsers();
    });

    $('#saveChangesRegisterUserButton').click(function () {
        $("#registerUserModal").modal('hide');
        registerUser(token);
        emptyPositionSelect();
    });

    $('#closeRegisterUserButton').click(function () {
        emptyPositionSelect();
    });

    function loadTable() {
        let config = {
            headers: {
                'Accept': 'application/json'
            }
        }
        fetch("{{route('users.all')}}" + "?page=" + page, config).then(function (response) {
            console.log(response)
            return response.json();
        }).then(function (data) {
            console.log(data);
            let table = $('#myTable').DataTable({
                stateSave: true,
                "aaSorting": [[6, 'desc']],
                columns: [
                    {
                        data: 'id', render: function (data, type, row) {
                            return '<button type="button" class="btn btn-secondary btn-sm"\n' +
                                `onclick="showUserModal(${data})">` + data + '</button>';
                        }
                    },
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
                columnDefs: [{
                    targets: [6],
                    render: function (data, type, row) {
                        return moment(data).format('YYYY/MM/DD/HH:mm:ss');
                    }
                }],
            });
            data.users.forEach(function (value) {
                table.row.add(value).draw();
            });
            page++;
        });
    }

    function showMoreUsers() {
        let config = {
            headers: {
                'Accept': 'application/json'
            }
        }
        fetch("{{route('users.all')}}" + "?page=" + page, config).then(function (response) {
            console.log(response);
            return response.json();
        }).then(function (data) {
            console.log(data);
            if(data.success) {
                data.users.forEach(function (value) {
                    $('#myTable').DataTable().row.add(value).draw();
                });
                page++;
            } else {
                alert(data.message);
            }
        });
    }

    function getPositions() {
        let config = {
            headers: {
                'Accept': 'application/json'
            }
        }
        fetch("{{route('positions')}}", config).then(function (response) {
            console.log(response);
            return response.json();
        }).then(function (data) {
            console.log(data);
            data.positions.forEach(function (value) {
                $('#positionSelect').append($('<option></option>').text(value.name).attr('value', value.id));
            });
        });
    }

    function getToken(callback) {
        let config = {
            headers: {
                'Accept': 'application/json'
            }
        }
        fetch("{{route('token')}}", config).then(function (response) {
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
            console.log(response);
            return response.json();
        }).then(function (data) {
            console.log(data);
            if(data.message === 'The token expired.'){
                alert(data.message + " You have to reload the page to start using new token");
            } else {
                if(data.message === 'Validation failed'){
                    let errors = '';
                    for (var i in data.fails) {
                        if (data.fails.hasOwnProperty(i)) {
                            errors += data.fails[i] + "\n";
                        }
                    }
                alert(data.message + "\n\n" + errors);
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function emptyPositionSelect() {
        $("#positionSelect").empty();
    }
</script>
