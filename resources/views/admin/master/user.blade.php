@extends('layouts.app-admin')

@section('title', '| User')
@section('breadcrumb', 'User ')

@section('content')

<style>
    input{
        text-align: left !important;
    }
    .waiting-for-fetch-data{
        position: fixed;
        background: rgb(0 0 0 / 0.53);
        height: 100%;
        width: 100vw;
        top: 0;
        font-weight: 500;
        z-index: 999 !important;
        font-size: 24px;
        color: #fff;
        justify-content: center;
        align-items: center;
        left: 0;
    }
    .waiting-for-fetch-data.active{
        display: flex;
    }
    .waiting-for-fetch-data.inactive{
        display:none;
    }
</style>
<div class="waiting-for-fetch-data inactive" id="waiting-for-fetch-data">

    <svg width="25" viewBox="-2 -2 42 42" class="mr-3" xmlns="http://www.w3.org/2000/svg" stroke="white" class="w-4 h-4 ml-3">
        <g fill="none" fill-rule="evenodd">
            <g transform="translate(1 1)" stroke-width="4">
                <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(114.132 18 18)">
                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                </path>
            </g>
        </g>
    </svg>

    Sedang memuat data ...
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header" style="padding:1.35rem 1.5rem 0rem 1.5rem;">
				<div class="d-flex justify-content-between align-items-baseline">
					<h5 class="card-title"> Users </h5>
					<button class="btn p-0" type="button" id="btn-refresh-user">
                    	<i class="icon-lg text-muted pb-3px" data-feather="refresh-cw"></i>
                    </button>
				</div>
			</div>
			<div class="card-body">
				<table class="table datatable-basic table-bordered table-striped table-hover table-responsive" id="data-table" style="border-top:solid 1px #ddd;width:100%;">
					<thead>
						<tr>
                            <th>Aksi</th>
                            <th>#</th>
                            <th>ID</th>
                            <th>Fullname</th>
                            <th>Email</th>
                            <th>Role</th>
							<th>Created At</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>



<button type="button" class="btn btn-primary btn-icon-text px-3 px-lg-4 btn-gradient float"  id="open-modal-user" style="font-size:17px;">
	<i class="link-icon" data-feather="plus-square"></i>&nbsp;
    Tambah User &nbsp;
</button>

<div class="modal fade" id="form-user-modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border:none;">
            <div class="modal-header" id="modal-header" style="background:rgb(42,143,204);background:linear-gradient(41deg, rgba(42,143,204,1) 0%, rgba(142,205,243,1) 50%);">
                <h5 class="modal-title" id="modal-title" style="color:#fff;">Edit Detail User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="cmxform" id="form-user" method="get" action="#" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset>
                    
                    <input type="hidden" name="id" id="id">

                    <div class="form-group">
                            <label>Fullname</label>
                            <input type="text" name="name" id="name"  class="form-control"  required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" id="email"  class="form-control"  required>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" id="role" class="form-control">
                                <option value="1">Admin</option>
                                <option value="2">User</option>
						    </select>
                        </div>

                        <div class="form-group mt-4" id="div_cb">
                            <div class="alert alert-primary" role="alert">
                                Kata sandi default adalah <b>password</b>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="close-user"> Batal </button>
                    <button type="submit" class="btn btn-primary btn-custom" id="save-user"> Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    let elm_waiting_for_fetch_data  = __getId('waiting-for-fetch-data')
    let elm_form_user              = __getId('form-user')
    let elm_save_user              = __getId('save-user')
    let elm_close_user             = __getId('close-user')
    let elm_open_modal             = __getId('open-modal-user')
    let elm_user_id                = __getId('id')


    $(document).ready(async function () {

        async function closeModalUser(e) {
            if(e) {
                e.preventDefault();
                $('#form-user-modal').modal('hide')
            }
        }


        elm_close_user.addEventListener('click', closeModalUser);
        elm_open_modal.addEventListener('click', openModalUser);


        // ----------- fetch data ------------------

        $.fn.dataTable.ext.errMode = 'none';

        table = $('#data-table').DataTable({
            pageLength: 10,
            processing: true,
            serverSide: true,
            autoWidth: true,
            order: [[2, 'DESC']],
            ajax:{
                url: "{{ url('api/user/data-table') }}",
                headers: {
                    'Authorization': "Bearer {{ Session::get('token') }}"
                },
                dataType: 'JSON',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                }
            },
            columns: [
                {
                    sClass: 'text-center',
                    orderable: false,
                    render: function(){
                        return `
                            <button class="btn p-0" type="button" id='edit-btn'>
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#2A8FCC" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                        `;
                    }
                },
                {
                    data: 'no',
                    sClass: 'text-center',
                    orderable: false,
                    width: '25px'
                },
                {
                    data: 'id',
                    width: '35px',
                    sClass: 'text-center',
                    orderable: false,
                },
                {
                    data: 'name',
                    width:'45%',
                    sClass: 'text-left',
                    orderable: false,

                },
                {
                    data: 'email',
                    width:'25%',
                    sClass: 'text-left',
                    orderable: false,
                },
                {
                    data: 'role',
                    sClass: 'text-center',
                    orderable: false,
                    render: function(data){
                        if(data){
                            let who = data == 1 ? 'Admin' : 'User';
                            return `${who}`;
                        }else{
                            return '-';
                        }
                    }
                },
                {
                    data: 'created_at',
                    sClass: 'text-center'
                },
            ]
        });

        function refreshUserDT(e) {
            if(e) {
                e.preventDefault()
            }
            table.ajax.reload(null, false);
        }

        // ----------- event listener----------------
        let elm_btn_refresh_user = __getId('btn-refresh-user')
        elm_btn_refresh_user.addEventListener('click', refreshUserDT)


        $('#data-table tbody').on('click', '#edit-btn', function () {
            
            elm_waiting_for_fetch_data.classList.replace('inactive', 'active');
            
            const data = table.row( $(this).parents('tr') ).data();
            
            __manageError('#form-user');

            $('#modal-title').empty().append('Edit User');

            __resetForm(elm_form_user); 

            for (const key in data) {

                for(const elm of elm_form_user) {
                    
                    if(key == elm.name) {
                        
                        if(elm.type == 'text' || elm.type == 'hidden' || elm.type == 'email' ) {
                            elm.value = data[key];
                        }
                        
                        if(elm.type == 'select-one') {
                            elm.value = data[key];
                            elm.dispatchEvent(new Event("change", {bubbles: true,}));
                        }

                    }

                }
            }

            elm_save_user.disabled = false;

            elm_waiting_for_fetch_data.classList.replace('active', 'inactive');

            __modalManage('#form-user-modal', 'show')


        });


        const rulesForm = {
            rules: {
                name: 'required',
                email: 'required',
                role: 'required',
                password: 'required',
            },
            ...rulesValidateGlobal,
            submitHandler:(form, e) => {
                e.preventDefault();

                const id =  elm_user_id.value ? elm_user_id.value : null;

                if(id) {
                    updateUser(e, id)
                } else {
                    saveUser(e)
                }

                return false;
            }
        }

        $('#form-user').submit((e) => {
            e.preventDefault();
        }).validate(rulesForm);


        async function saveUser(e) {
            if(e) {
                e.preventDefault();
            }

            elm_save_user.innerHTML = 'Menyimpan ' + ___iconLoading();
            elm_save_user.disabled = true;

            let formData = new FormData(elm_form_user);

            $.ajax({
                url:`{{ url('api/user/create') }}`,
                headers: {
                    'Authorization': "Bearer {{ Session::get('token') }}"
                },
                method:"POST",
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(result){
                    const {status, message, data} = result;

                    if(status) {

                        refreshUserDT();

                        toastr.success(message, { fadeAway: 10000 });
                        elm_save_user.innerHTML = 'Simpan';
                        elm_save_user.disabled = false;

                        $('#form-user-modal').modal('hide')
                    } else {
                        elm_save_user.disabled = false;
                        elm_save_user.innerHTML = 'Simpan';

                        $('#form-user-modal').modal('hide')
                    }
                },
                error: function(err) {
                    const msg = err.responseJSON.message;

                    toastr.error(msg,  { fadeAway: 10000 });

                    elm_save_user.innerHTML = 'Simpan';

                }
            })


        }

        async function updateUser(e, id) {
            if(e) {
                e.preventDefault();
            }

            elm_save_user.innerHTML = 'Menyimpan ' + ___iconLoading();
            elm_save_user.disabled = true;


            let formData = new FormData(elm_form_user);

            $.ajax({
                url:`{{ url('api/user/update/${id}') }}`,
                headers: {
                    'Authorization': "Bearer {{ Session::get('token') }}"
                },
                method:"POST",
                data: formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(result){
                    const {status, message, data} = result;

                    if(status) {

                        refreshUserDT();

                        toastr.success(message, { fadeAway: 10000 });
                        elm_save_user.innerHTML = 'Simpan';
                        elm_save_user.disabled = false;

                        $('#form-user-modal').modal('hide')
                    } else {
                        elm_save_user.disabled = false;
                        elm_save_user.innerHTML = 'Simpan';

                        log(message);
                        toastr.error(message,  { fadeAway: 10000 });

                        $('#form-user-modal').modal('hide')
                    }
                },
                error: function(err) {

                    const msg = err.responseJSON.message;

                    toastr.error(msg,  { fadeAway: 10000 });

                    // $('#form-brand-modal').modal('hide')

                    elm_save_user.innerHTML = 'Simpan';
                }
            })

        }


        async function openModalUser() {

            $('#modal-title').empty().append('Tambah User');
            $('#form-user-modal').modal('show');
            
            __manageError('#form-user')
            __resetForm(elm_form_user);

            elm_save_user.disabled = false;
            elm_save_user.removeAttribute('disabled', '')
        }

    });




</script>

@endsection
