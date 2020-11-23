<html>
<head>
	<meta charset="utf-8">
	<link rel="icon" href="https://www.iconfinder.com/data/icons/most-usable-logos/120/Amazon-512.png?w=800&h=800" />
	<title>DoTQ App</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
</head>
<body>
    <div class="container">
        <br />
        <h3 align="center">CRUD REST API in Codeigniter</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add User</h4>
                </div>
                <div class="modal-body">
                    <label>Enter First Name</label>
                    <input type="text" name="first_name_fromv" id="first_name_fromv" class="form-control" />
                    <span id="first_name_error" class="text-danger"></span>
                    <br />
                    <label>Enter Last Name</label>
                    <input type="text" name="last_name_fromv" id="last_name_fromv" class="form-control" />
                    <span id="last_name_error" class="text-danger"></span>
                    <br />
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id_fromv" id="user_id_fromv" />
                    <input type="hidden" name="data_action_fromv" id="data_action_fromv" value="InsertFromV" />
                    <input type="submit" name="label_action" id="label_action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
    
    // SEL
    function fetch_data()
    {
        $.ajax({
            // 1) access "http://localhost:8000/index.php/test_api" với param="FetchAllFromV"
            // 2) Test_api.php>onActionCRUD(): access "http://localhost:8000/index.php/api"
            // 3) Api.php>index(): call Api_model.php>fetch_all_fromm(): SEL * FROM tbl_sample -> trả về JSON string
            // 4) Test_api.php>action(): JSON string -> PHP array -> trả HTML data về cho Ajax req của api_view.php
            url:"<?php echo site_url(); ?>/test_api/onActionCRUD",
            method:"POST",
            data:{data_action_fromv:'FetchAllFromV'},
            success:function(arg_data)
            {
                $('tbody').html(arg_data);
            }
        });
    }

    fetch_data();

    // khi click "Add" thì show DLG "userModal" & INS
    $('#add_button').click(function(){
        $('#user_form')[0].reset();
        $('.modal-title').text("Add User Title");
        $('#label_action').val('OK Add');
        $('#data_action_fromv').val("InsertFromV");
        $('#userModal').modal('show');
        $('#first_name_error').html('');
        $('#last_name_error').html('');
    });

    $(document).on('submit', '#user_form', function(event){ // submit '#user_form' bao gồm INS & UPD
        event.preventDefault();
        $.ajax({
            url:"<?php echo site_url(); ?>/test_api/onActionCRUD",
            method:"POST",
            data:$(this).serialize(),
            dataType:"json",
            success:function(arg_data)
            {
                if(arg_data.success)
                {
                    $('#user_form')[0].reset();
                    $('#userModal').modal('hide');
                    fetch_data();
                    if($('#data_action_fromv').val() == "InsertFromV")
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                    }
                }
                if(arg_data.error)
                {
                    $('#first_name_error').html(arg_data.first_name_error);
                    $('#last_name_error').html(arg_data.last_name_error);
                }
            }
        })
    });

    // UPD
    $(document).on('click', '.edit', function(){ // click "Edit" (map với name="edit")
        var user_id = $(this).attr('id');
        $.ajax({
            url:"<?php echo site_url(); ?>/test_api/onActionCRUD",
            method:"POST",
            // UPD-SEL
            data:{user_id_fromv:user_id, data_action_fromv:'FetchSingleFromV'},
            dataType:"json",
            success:function(arg_data)
            {
                console.log("arg_data: ", arg_data);
                // KO có if(arg_data.success/error) giống INS vì arg_data chỉ có first/last_name > trả về "undefined" > xử lí die luôn!!!
                $('#userModal').modal('show');
                $('#first_name_error').html('');
                $('#last_name_error').html('');
                $('#first_name_fromv').val(arg_data.first_name);
                $('#last_name_fromv').val(arg_data.last_name);
                $('.modal-title').text('Edit User Title');
                $('#user_id_fromv').val(user_id);
                $('#label_action').val('OK Edit');
                $('#data_action_fromv').val('EditFromV');
            }
        })
    });

    // DEL
    $(document).on('click', '.delete', function(){ // click "Delete" (map với name="delete")
        var user_id = $(this).attr('id');
        var st_name = $(this).attr('value');
        if(confirm("Are you sure you want to delete " + st_name + "?"))
        {
            $.ajax({
                url:"<?php echo site_url(); ?>/test_api/onActionCRUD",
                method:"POST",
                data:{user_id_fromv:user_id, data_action_fromv:'DeleteFromV'},
                dataType:"JSON",
                success:function(arg_data)
                {
                    if(arg_data.success)
                    {
                        $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                        fetch_data();
                    }
                }
            })
        }
    });
    
});
</script>