<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} @yield('title')</title>
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  	<style>
		  .float{
			position: fixed;
			bottom: 40px;
			right: 40px;
			box-shadow: 2px 2px 15px -4px rgba(0,0,0,0.5);
			height: 40px;
			z-index: 1039;
		}
	</style>

	@yield('style')

</head>
<body class="sidebar-light" style="cursor:default;">

	<div class="main-wrapper">

		@include('layouts.partials.sidebar')

		<div class="page-wrapper">

			@include('layouts.partials.navbar')

			<div class="page-content" style="background-color:#fff;">

				<nav aria-label="breadcrumb" class="mb-4">
					<ol class="breadcrumb bg-primary" style="background:rgb(42,143,204);background:linear-gradient(41deg, rgba(42,143,204,1) 0%, rgba(142,205,243,1) 50%);">
						<li class="breadcrumb-item active" aria-current="page"> @yield('breadcrumb') </li>
					</ol>
				</nav>

        		@yield('content')

			</div>
		
		</div>
	</div>

	<!-- Loading  -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  	<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js" integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{ asset('assets/js/notification.js') }}"></script>

</body>
<script>

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

function __modalManage(name, type) {
    switch(type) {
        case 'hide':
            $(`${name}`).modal("hide");
        break;
        case 'show':
            $(`${name}`).modal("show");
        break;
    }
}



function __manageError(elm_name) {
	$(`${elm_name} input.has-error`).removeClass('has-error');
	$(`${elm_name} textarea.has-error`).removeClass('has-error');
	$(`${elm_name} select.has-error`).removeClass('has-error');
	$(`${elm_name} .help-inline.text-danger`).remove()
}


function __resetForm(elm_name) {
	for(const elm of elm_name) {
		elm.value = '';
		if(elm.type == 'select-one') {
			elm.dispatchEvent(new Event("change", {bubbles: true,}));
		}
	}
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

@yield('js')

</html>