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
    <div id="id-1" class="container">
        <br />
        <h3 align="center">CRUD REST API in Codeigniter</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs"
                        @click="vueShowUserModal=true"
                        >Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="alert alert-success col-md-6" id="alertMessage" role="alert" v-if="vueSuccessMessage">
					{{ vueSuccessMessage }}
				</div>
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
                        <tr v-for="item_user in vueUsers">
                            <td>{{item_user.first_name}}</td>
                            <td>{{item_user.last_name}}</td>
                            <td>
                                <button type="button" class="btn btn-warning" :id="item_user.id"
                                @click="vueShowUpdUser=true; vueFetchSingleFromV(item_user);"
                                >
                                    Edit
                                </button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger" :id="item_user.id" @click="vueFetchSingleFromV(item_user); vueDeleteFromV();">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- INS -->
        <div id="userModal" v-if="vueShowUserModal" class="modal show">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add User</h4>
                        </div>
                        <div class="modal-body">
                            <label>Enter First Name</label>
                            <input type="text" id="first_name_fromv" class="form-control" v-model="vueNewUser.first_name"/>
                            <br />
                            <label>Enter Last Name</label>
                            <input type="text" id="last_name_fromv" class="form-control" v-model="vueNewUser.last_name"/>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="label_action" class="btn btn-success"
                                @click="vueShowUserModal=false; vueInsertFromV();"
                            >Add</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                @click="vueShowUserModal=false"
                            >Close</button>
                        </div>
                    </div>
            </div>
        </div>

        <!-- UPD -->
        <div id="userModal" v-if="vueShowUpdUser" class="modal show">
            <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit User</h4>
                        </div>
                        <div class="modal-body">
                            <label>Edit First Name</label>
                            <input type="text" id="first_name_upd" class="form-control" v-model="vueClickedUser.first_name"/>
                            <br />
                            <label>Edit Last Name</label>
                            <input type="text" id="last_name_upd" class="form-control" v-model="vueClickedUser.last_name"/>
                            <br />
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="label_action" class="btn btn-success"
                                @click="vueShowUpdUser=false; vueEditFromV();"
                            >Edit</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                @click="vueShowUpdUser=false"
                            >Close</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="container" id="uploadApp">
        <br />
        <h3 align="center">How to upload file using Vue.js with PHP</h3>
        <br />
        <div v-if="vueSuccessAlert" class="alert alert-success alert-dismissible">
            <a href="#" class="close" aria-label="close" @click="vueSuccessAlert=false">&times;</a>
            {{ vueUpSuccessMsg }}
        </div>

        <div v-if="vueErrorAlert" class="alert alert-danger alert-dismissible">
            <a href="#" class="close" aria-label="close" @click="vueErrorAlert=false">&times;</a>
            {{ vueUpErrMsg }}
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
            <div class="row">
            <div class="col-md-6">
            <h3 class="panel-title">Upload File</h3>
            </div>
            <div class="col-md-6" align="right">
            
            </div>
            </div>
            </div>
            <div class="panel-body">
            <div class="row">
            <div class="col-md-4">
            <label>Select Image</label>
            </div>
            <div class="col-md-4">
            <input type="file" ref="file" />
            </div>
            <div class="col-md-4">
            <button type="button" @click="uploadImage" class="btn btn-primary">Upload Image</button>
            </div>
            </div>
            <br />
            <br />
            <div v-html="vueUploadedImage" align="center"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var vueUploadApp = new Vue({
            el:'#uploadApp',
            data:{
                vueUpSuccessMsg:'',
                vueUpErrMsg:'',
                vueFile:'',
                vueSuccessAlert:false,
                vueErrorAlert:false,
                vueUploadedImage:"<img src='http://via.placeholder.com/300' class='img-thumbnail' />",
            },
            methods:{
                uploadImage:function(){
                    vueUploadApp.vueFile = vueUploadApp.$refs.file.files[0];
                    var formData = new FormData();
                    formData.append('file', vueUploadApp.vueFile);
                    axios.post('http://localhost:8000/index.php/api/onUploadFile', formData, {
                        header:{
                            'Content-Type' : 'multipart/form-data'
                        }
                    }).then(function(response){
                        if(response.data.image == '')
                        {
                            vueUploadApp.vueErrorAlert = true;
                            vueUploadApp.vueSuccessAlert = false;
                            vueUploadApp.vueUpErrMsg = response.data.message;
                            vueUploadApp.vueUpSuccessMsg = '';
                            vueUploadApp.vueUploadedImage = "<img src='http://via.placeholder.com/300' class='img-thumbnail' />";
                        }
                        else
                        {
                            vueUploadApp.vueErrorAlert = false;
                            vueUploadApp.vueSuccessAlert = true;
                            vueUploadApp.vueUpErrMsg = '';
                            vueUploadApp.vueUpSuccessMsg = response.data.message;
                            var image_html = "<img src='"+response.data.image+"' class='img-thumbnail' width='600' />";
                            vueUploadApp.vueUploadedImage = image_html;
                            vueUploadApp.$refs.file.value = '';
                        }
                    });
                }
            },
        });

        var vueId1 = new Vue({
            el: '#id-1',
            data: {
                vueSuccessMessage: "",
                vueShowUserModal: false,
                vueShowUpdUser: false,
                vueUsers: [],
                vueNewUser: {first_name: "", last_name: ""},
                vueCurrentUser: {},
                vueClickedUser: {},
            },
            mounted: function() {
                this.vueFetchAllFromV();
            },
            methods:{
                vueFetchAllFromV(){
                    axios.get("http://localhost:8000/index.php/api/onSelectAll").then(function(response){
                        if (response.data.error) {
                            alert(JSON.stringify(response.data));
                        } else {
                            vueId1.vueUsers = response.data;
                        }
                    })
                },
                vueInsertFromV() {
                    var arg_ins = 'first_name_from_test=' + vueId1.vueNewUser.first_name + '&last_name_from_test=' + vueId1.vueNewUser.last_name;
                    axios.post('http://localhost:8000/index.php/api/onInsert', arg_ins)
                    .then(function (response) {
                        vueId1.vueNewUser = {first_name: "", last_name: ""};
                        var { data } = response;
                        var {error, first_name_error,last_name_error} = data;
                        if (error) {
                            var str_err_msg = "";
                            if (first_name_error) {
                                str_err_msg += "\n" + first_name_error;
                            }
                            if (last_name_error) {
                                str_err_msg += "\n" + last_name_error;
                            }
                            alert(str_err_msg);
                        } else {
                            vueId1.vueSuccessMessage = 'Data Inserted';
                            vueId1.vueFetchAllFromV();
                        }
                    });
                },
                vueEditFromV() {
                    var arg_upd = 'id_from_test=' + vueId1.vueClickedUser.id + '&first_name_from_test=' + vueId1.vueClickedUser.first_name + '&last_name_from_test=' + vueId1.vueClickedUser.last_name;
                    axios.post('http://localhost:8000/index.php/api/onUpdate', arg_upd)
                    .then(function (response) {
                        vueId1.vueClickedUser = {};
                        var { data } = response;
                        var {error, first_name_error,last_name_error} = data;
                        if (error) {
                            var str_err_msg = "";
                            if (first_name_error) {
                                str_err_msg += "\n" + first_name_error;
                            }
                            if (last_name_error) {
                                str_err_msg += "\n" + last_name_error;
                            }
                            alert(str_err_msg);
                        } else {
                            vueId1.vueSuccessMessage = 'Data Updated';
                        }
                        vueId1.vueFetchAllFromV();
                    });
                },
                vueDeleteFromV() {
                    var {id, first_name, last_name} = vueId1.vueClickedUser;
                    if(confirm("Are you sure you want to delete " + first_name + " " + last_name + "?")){
                        var arg_del = 'id_from_test=' + id;
                        axios.post('http://localhost:8000/index.php/api/onDelete', arg_del)
                        .then(function (response) {
                            vueId1.vueClickedUser = {};
                            var { data } = response;
                            var {error} = data;
                            if (error) {
                                alert(JSON.stringify(data));
                            } else {
                                vueId1.vueSuccessMessage = 'Data Deleted';
                                vueId1.vueFetchAllFromV();
                            }
                        });
                    }
                },
                vueFetchSingleFromV(arg_user) {
                    vueId1.vueClickedUser = arg_user;
                },
            }
        })
    </script>
</body>
</html>