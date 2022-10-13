@extends('layouts.app-admin')

@section('title', '| Article')
@section('breadcrumb', 'Article ')

@section('content')

<style>
    .dropify-wrapper{
        height: 100px !important;
    }
    .dropify-wrapper .dropify-message p{
    font-size: 16px;
}

</style>



<button type="button" class="btn btn-primary btn-icon-text px-3 px-lg-4 btn-gradient float"  id="open-modal-article" style="font-size:17px;">
	<i class="link-icon" data-feather="plus-square"></i>&nbsp;
    Tambah Article &nbsp;
</button>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header" style="padding:1.35rem 1.5rem 0rem 1.5rem;">
				<div class="d-flex justify-content-between align-items-baseline">
					<h5 class="card-title"> Article </h5>
					<button class="btn p-0" type="button" id="btn-refresh-article">
                    	<i class="icon-lg text-muted pb-3px" data-feather="refresh-cw"></i>
                    </button>
				</div>
			</div>
			<div class="card-body">


    <div class="table-responsive">

				<table class="table datatable-basic table-bordered table-striped table-hover" id="data-table" style="border-top:solid 1px #ddd;width:100%;">
					<thead style="position:relative">
						<tr>
							<th>Aksi</th>
							<th>#</th>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
							<th>Content</th>
							<th>Created By</th>
							<th>Created At</th>
							<th>Updated At</th>
                        </tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="form-article-modal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border:none;">
            <div class="modal-header" id="modal-header" style="background:rgb(42,143,204);background:linear-gradient(41deg, rgba(42,143,204,1) 0%, rgba(142,205,243,1) 50%);">
                <h5 class="modal-title" style="color:#fff;">Edit Article</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff;opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="cmxform" id="form-article" method="get" action="#" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset>
                        <div class="form-group" style="margin-bottom:0px;">
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group">
                            <label>Thumbnail</label>
                            <input type="file" name="file" id="file" class="dropify"  data-height="150" data-errors-position="outside" data-allowed-file-extensions="png jpeg jpg gif" data-max-file-size="2M"/ >
                        </div>
                        
                        <div class="form-group">
                            <label> Title </label>
                            <input type="text" class="form-control" id="title" name="title" autocomplete="off" placeholder="Masukkan kode article" required>
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea id="content" class="form-control" name="content" type="text"  autocomplete="off" placeholder="Masukkan nama article" rows="8"></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" id="close-article"> Batal </button>
                    <button type="submit" class="btn btn-primary btn-custom" id="save-article"> Simpan </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

    $(document).ready(async function () {

        let elm_id = __getId('id')
        let elm_name = __getId('prod-type-id')
        let elm_form_article = __getId('form-article')
        let elm_save_article = __getId('save-article')
        let elm_close_article = __getId('close-article')
        let elm_btn_refresh_article = __getId('btn-refresh-article')
        let elm_modal_header = __getId('modal-title')

        const __propsPOST = Object.assign({}, porpertyPOST())

        var drEvent = $('#file').dropify({
            messages: {
                default: 'Drag atau drop untuk memilih gambar',
                replace: 'Ganti',
                remove:  'Hapus',
                error:   'error'
            }
        });

        drEvent.on('dropify.afterClear', function(event, element){
            elm_save_article.disabled = true;
        });

        drEvent.on('dropify.fileReady', function(event, element){
            elm_save_article.disabled = false;
        });

        drEvent.on('dropify.errors', function(event, element){
            elm_save_article.disabled = true;
        });

        const isSuccessfullyGettingData = {
            article: false
        }


        let table = null
        let elm_open_modal = __getId('open-modal-article')
        // ----------- fetch data ------------------

        $.fn.dataTable.ext.errMode = 'none';

        function fDataTable() {
        table = $('#data-table').DataTable({
            "searchable": false,
            orderCellsTop: true,
            pageLength:10,
            processing: true,
            serverSide: true,
            autoWidth: true,
            order: [[0, 'ASC']],
            ajax:{
                url: "{{ url('api/article/data-table') }}",
                dataType: 'JSON',
                type: 'POST',
                headers: {
                    'Authorization': "Bearer {{ Session::get('token') }}"
                },
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
                                <svg viewBox="0 0 24 24" width="15" height="15" stroke="#2A8FCC" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            &nbsp;&nbsp;
                            <button class="btn p-0" type="button" id='delete-btn'>
                                <svg viewBox="0 0 24 24" width="15" height="15" stroke="#FF3366" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
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
                    sClass: 'text-center'
                },
                {
                    data: 'image',
                    sClass: 'text-center',
                    orderable: false,
                    render: function(data){
                        console.log(data);
                        if(data != '-'){
                            return `<img src="{{ url('${data}')  }}" id="zoom-foto" style="height:25px;width:auto;border-radius:5%;cursor:pointer;" draggable="false">`;
                        }else{
                            return '-';
                        }
                    }
                },
                {
                    data: 'title',
                    sClass: 'text-center'
                },
                {
                    data: 'content',
                    width: '30%',
                    render:function(data) {
                        return `${data.substr(0, 70)}...`
                    }
                },
                {
                    data: 'created_by',
                    sClass: 'text-center'
                },
                {
                    data: 'created_at',
                    sClass: 'text-center'
                },
                {
                    data: 'updated_at',
                    sClass: 'text-center'
                },
            ]
        });

        }

   
        $('#data-table').DataTable().destroy();
        fDataTable();  


        // ----------- init ---------------------

        const rulesForm = {
            rules: {
                principle_id: 'required',
                content : 'required',
            },
            ...rulesValidateGlobal,
            submitHandler:(form, e) => {
                e.preventDefault();

                const id =  elm_id.value ? elm_id.value : null;

                if(id) {
                    updateArticle(e, id)
                } else {
                    saveArticle(e)
                }

                return false;
            }
        }

        $('#form-article').submit((e) => {
            e.preventDefault();
        }).validate(rulesForm);


         // ----------- function ---------------------


         async function saveArticle(e) {
            if(e) {
                e.preventDefault();
            }

            elm_save_article.innerHTML = 'Menyimpan ' + ___iconLoading();
            elm_save_article.disabled = true;

            let formData = new FormData(elm_form_article);

            $.ajax({
                url:`{{ url('api/article/create') }}`,
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

                        refreshArticleDT();

                        toastr.success(message, { fadeAway: 10000 });
                        elm_save_article.innerHTML = 'Simpan';
                        elm_save_article.disabled = false;

                        $('#form-article-modal').modal('hide')
                    } else {
                        elm_save_article.disabled = false;
                        elm_save_article.innerHTML = 'Simpan';


                        $('#form-article-modal').modal('hide')
                    }
                },
                error: function(err) {
                    const msg = err.responseJSON.message;

                    toastr.error(msg,  { fadeAway: 10000 });

                    elm_save_article.innerHTML = 'Simpan';

                }
            })


        }

        async function updateArticle(e, id) {
            if(e) {
                e.preventDefault();
            }

            elm_save_article.innerHTML = 'Menyimpan ' + ___iconLoading();
            // elm_save_article.disabled = true;


            let formData = new FormData(elm_form_article);

            $.ajax({
                url:`{{ url('api/article/update/${id}') }}`,
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

                        refreshArticleDT();

                        toastr.success(message, { fadeAway: 10000 });
                        elm_save_article.innerHTML = 'Simpan';
                        elm_save_article.disabled = false;

                        $('#form-article-modal').modal('hide')
                    } else {
                        elm_save_article.disabled = false;
                        elm_save_article.innerHTML = 'Simpan';

                        toastr.error(message,  { fadeAway: 10000 });

                        $('#form-article-modal').modal('hide')
                    }
                },
                error: function(err) {

                    const msg = err.responseJSON.message;

                    toastr.error(msg,  { fadeAway: 10000 });

                    // $('#form-article-modal').modal('hide')

                    elm_save_article.innerHTML = 'Simpan';
                }
            })


        }


        function resetForm() {
            var drEvent = $('#file').dropify();
            drEvent = drEvent.data('dropify');
            drEvent.resetPreview();
            drEvent.clearElement();

            for(const elm of elm_form_article) {
                elm.value = '';
                if(elm.type == 'select-one') {
                    elm.dispatchEvent(new Event("change", {bubbles: true,}));
                }
            }
        }


        async function closeModalArticle(e) {
            if(e) {
                e.preventDefault();
                $('#form-article-modal').modal('hide')
            }
        }

        async function openModalArticle() {

            $('#modal-title').empty().append('Tambah Article');

            $('#form-article-modal').modal('show');

            // manage error
            $('#form-article input.has-error').removeClass('has-error');
            $('#form-article textarea.has-error').removeClass('has-error');
            $('#form-article select.has-error').removeClass('has-error');
            $('#form-article .help-inline.text-danger').remove()

            $('.dropify-error').empty();
            //$('.dropify-errors-container').empty();

            resetForm();

            elm_save_article.disabled = false;
            elm_save_article.removeAttribute('disabled', '')
        }


        async function __swalConfirmation(title = 'Apakah anda yakin ?', text = 'Apakah anda yakin ingin menghapusnya ?', id) {
            return swal({
                title: title,
                text: text,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then(async (willDelete) => {
                if (willDelete) {

                    try {

                        let res = await fetch(`{{ url('api/article/delete/${id}') }}`, Object.assign({}, __propsPOST, {
                            method: 'DELETE'
                        }))

                        let result = await res.json();

                        const {status, message} = result;

                        if(status) {
                            refreshArticleDT();
                            toastr.success(message, { fadeAway: 10000 });
                        } else {
                            toastr.error('Ops.. something went wrong!',  { fadeAway: 50000 });
                        }
                    } catch (error) {
                        console.error(error);
                    }
                }
            })
        }

        function refreshArticleDT(e) {
            if(e) {
                e.preventDefault()
            }
            table.ajax.reload(null, false);
        }

        // ----------- event listener----------------

        elm_btn_refresh_article.addEventListener('click', refreshArticleDT)
        elm_open_modal.addEventListener('click', openModalArticle);
        elm_close_article.addEventListener('click', closeModalArticle);


        $('#data-table tbody').on('click', '#delete-btn', function () {
            const data = table.row( $(this).parents('tr') ).data();

            __swalConfirmation('Apakah anda yakin ?', 'Apakah anda yakin ingin menghapusnya ?', data.id)

        });


        $('#data-table tbody').on('click', '#edit-btn', function () {
            // manage error
            $('#form-article input.has-error').removeClass('has-error');
            $('#form-article textarea.has-error').removeClass('has-error');
            $('#form-article select.has-error').removeClass('has-error');
            $('#form-article .help-inline.text-danger').remove()
            $('.dropify-error').empty();
            $('.dropify-errors-container').empty();

            $('#modal-title').empty().append('Edit Article');

            resetForm();

            const data = table.row( $(this).parents('tr') ).data();

            elm_id.value = data.id;

            $("select#principle_id option").each(function(){
                this.selected = (this.text == data.principle);
            }).change();

            for (const key in data) {
                for(const elm of elm_form_article) {
                    if(key == elm.name) {
                        if(elm.type == 'text' || elm.type == 'hidden' || elm.type == 'textarea') {
                            elm.value = data[key];
                        }
                        if(elm.type == 'select-one') {
                            elm.value = data[key];
                            elm.dispatchEvent(new Event("change", {bubbles: true,}));
                        }
                    }
                    if(key == 'article_logo' && elm.name == 'logo') {

                        let img = data[key] ? `{{ url('/${data[key]}') }}` : imageNotFound();
                        
                        var drEvent = $('#file').dropify({
                            defaultFile: `${img}`,
                        });

                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = `${img}`;
                        drEvent.destroy();
                        drEvent.init();

                        $('.dropify-render > img').attr('src', `${img}`);

                    }
                }
            }

            elm_save_article.disabled = false;

            $('#form-article-modal').modal('show');

        });

    });


var imageNotFound = () => 'https://zoomnearby.com/resources/media/images/common/Image-not-found.jpg'


function __getId(name) {
	return document.getElementById(name);
}

function porpertyPOST(body) {
	return {
		headers: __headers(),
		method: 'POST',
		body: JSON.stringify(body)
	};
}

function __headers() {
	return {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
		Accept: 'application/json, text/plain, */*',
		'Content-type': 'application/json',
		Authorization: "Bearer {{ Session::get('token') }}"
	};
}


function __querySelectorAll(tag) {
	return document.querySelectorAll(tag);
}

function __querySelector(tag) {
	return document.querySelector(tag);
}


function ___iconLoading(color = 'white', width = 25) {
    return `<svg width="${width}" viewBox="-2 -2 42 42" xmlns="http://www.w3.org/2000/svg" stroke=${color} class="w-4 h-4 ml-3">
        <g fill="none" fill-rule="evenodd">
            <g transform="translate(1 1)" stroke-width="4">
                <circle stroke-opacity=".5" cx="18" cy="18" r="18"></circle>
                <path d="M36 18c0-9.94-8.06-18-18-18" transform="rotate(114.132 18 18)">
                    <animateTransform attributeName="transform" type="rotate" from="0 18 18" to="360 18 18" dur="1s" repeatCount="indefinite"></animateTransform>
                </path>
            </g>
        </g>
    </svg>`;
    }


var rulesValidateGlobal = {
	onfocusout: (elm) => {
		return $(elm).valid();
	},
	ignore: [],
	errorClass: 'error',
	errorElement: 'span',
	errorClass: 'help-inline text-danger',
	errorElement: 'span',
	highlight: (elm, errorClass, validClass) => {
		$(elm).addClass('has-error');
	},
	unhighlight: (elm, errorClass, validClass) => {
		$(elm).removeClass('has-error');
	},
	errorPlacement: function(error, elm) {
		if (elm.hasClass('select2-hidden-accessible')) {
			error.insertAfter(elm.next('.select2.select2-container.select2-container--default'));
		} else {
			error.insertAfter(elm);
		}
	}
};

</script>

@endsection
