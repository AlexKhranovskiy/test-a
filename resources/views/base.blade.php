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
            <button type="button" id="newCategoryButton" class="btn btn-secondary btn-sm">New</button>
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
<button id="button1">set array</button>
<button id="button2">load to table</button>
<!-- Modal for create-->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label for="inputCreateCategoryName" id="inputCreateCategoryId">Name:</label>
                <input id="inputCreateCategoryName" name="categoryName" type="text"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" id="saveChangesCreateCategoryButton" class="btn btn-primary btn-sm">Save changes
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
    //let users = [];
    let page = 1;

    function showCreateModal() {
        $("#createModal").modal();
    }

    function showEditModal(categoryId) {
        let url = '{{route('users.show', '')}}' + '/' + categoryId;
        $('#deleteCategoryButton').val(categoryId);
        $.ajax({
            method: "get",
            url: url,
            success: function (response) {
                $("#inputEditCategoryId").text(response.id).val(response.id);
                $("#inputEditCategoryName").val(response.name);
                $("#editModal").modal();
            }
        });
    }

    // $(document).ready(function () {
    let table = loadTable();
    //table.data = load();
    // $.ajaxSetup({
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     }
    // });


    $('#newCategoryButton').click(function () {
        showCreateModal();
    });

    $('#showMoreUsersButton').click(function () {
        //table.destroy();
        showMoreUsers();
        //table.ajax.reload();
        //window.table.reload();
    });

    $('#button1').click(function () {
        page++;

    });

    $('#button2').click(function () {
        var table = $('#myTable').DataTable();
        table.row.add(users[0][0]).draw();


        // let dataSource;
        // users.forEach(function(value, index){
        //     dataSource.push(value);
        // });
        // console.log(dataSource);
        //table.destroy();
        // new DataTable('#myTable', {
        //     stateSave: true,
        //     columns: [
        //         {data: 'id'},
        //         {data: 'name'},
        //         {data: 'email'},
        //         {data: 'phone'},
        //         {data: 'position'},
        //         {data: 'position_id'},
        //         {data: 'registration_timestamp'},
        //         {data: 'photo'}
        //     ],
        //     data: users[0]
        // });
    });

        $('#saveChangesCreateCategoryButton').click(function () {
            $("#createModal").modal('hide');
            $.ajax({
                method: "post",
                url: '{{route('users.register')}}',
                dataType: 'json',
                data: {
                    'name': $("#inputCreateCategoryName").val()
                },
                success: function (data) {
                    $("#alertSuccess").text('New category successfully created')
                        .fadeIn(300).delay(2000).fadeOut(400);
                    table.ajax.reload();
                    console.log(data);
                }
            });
        });
        // $('body').on('click', '#deleteCategoryButton', function () {
        // }).on('click', '#saveChangesEditCategoryButton', function () {
        // }).on('click','#newCategoryButton', function () {
        // }).on('click', '#saveChangesCreateCategoryButton', function () {
        // });
        //});

        function loadTable() {
           let result = $('#myTable').DataTable({
                ajax: {
                    url: "{{route('users.all')}}" + "?page=" + page,
                    dataSrc: 'users'
                },
                stateSave: true,
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'email'},
                    {data: 'phone'},
                    {data: 'position'},
                    {data: 'position_id'},
                    {data: 'registration_timestamp'},
                    {data: 'photo'}
                ],
            });
            page++;
            return result;
        }

        function showMoreUsers() {
            fetch("{{route('users.all')}}" + "?page=" + page).then(function (response) {
                return response.json();
            }).then(function (data) {
                //console.log(data.users);
                if (data.success) {
                    //users.push(data.users);
                    let users = data.users;
                    console.log(users, page);
                    //table = $('#myTable').DataTable();
                    users.forEach(function (value){
                        table.row.add(value).draw();
                    });


                } else {
                    // proccess server errors } })
                }
            });
            page++;
        }

    {{--function doo(){--}}
    {{--    fetch('{{route('api.category.destroy', '')}}' + '/' + '12',  {--}}
    {{--        method: 'DELETE'--}}
    {{--    });--}}
    {{--    window.table.ajax.reload();--}}
    {{--}--}}

</script>
