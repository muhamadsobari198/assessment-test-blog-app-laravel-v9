<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>{{ env('APP_NAME') }} | Login</title>
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/notification.css') }}">
</head>
<body>

	<div id="notification" style="display:none;background:#EE5E64;">
	</div>

	<div class="main-wrapper">
		<div class="page-wrapper full-page" style="background: url({{ asset('https://images.pexels.com/photos/6192510/pexels-photo-6192510.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')  }}) no-repeat center center fixed;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-12 col-md-6 col-lg-6 col-xl-4 mx-auto">
						<div class="card">
							<div class="row">
								<div class="col-md-12 pl-md-0">
									<div class="auth-form-wrapper px-4 py-4 mt-2 mb-2 ml-2 mr-1">
										<center>
											<a class="sidebar-brand" style="color:#606060; font-size: 27px;font-weight:bold">
												Test <span style="color:#2A8FCC;">goKampus</span>
											</a>
										</center>
										<hr class="mb-4">
										<form id="login-form">
											<div class="form-group">
												<label>Email</label>
												<input type="text" class="form-control" name="email" id="email" placeholder="Masukkan Email" autofocus>
											</div>
											<div class="form-group">
												<label>Kata Sandi</label>
												<input type="password" class="form-control" name="password" placeholder="Masukkan Kata Sandi">
											</div>
											<div class="mt-4">
												<button type="submit" class="btn btn-primary btn-block btn-gradient text-white" style="padding-top:11px;padding-bottom:11px;"><span class="spinner-border spinner-border-sm" id="btn_loading" style="display:none;"></span>&nbsp; Login &nbsp;</button>
											</div>
										</form>
										<hr class="mt-4 mb-4">
										<a href="" class="a-href"> Lupa Kata Sandi? </a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/notification.js') }}"></script>
</body>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$('#login-form').on('submit', function(e){
		e.preventDefault();

		$.ajax({
			url:`{{ url('/login') }}`,
			type:'POST',
			data: $(this).serialize(),
			dataType: 'json',
			beforeSend:function(){
				$('#btn_loading').show();
				$('#login-form').find('input,button').attr('disabled', true);
				closeNotif();
			},
			success:function(res){
				showNotif('success', res.message);

				setTimeout(function(){
					window.location.href = "{{ url('verify-token') }}/" + res.user.email + '||' + res.token;
				}, 1000);
			},
			error:function(err){
				err = err.responseJSON.message;

					setTimeout(function(){

						showNotif('error', err);

						$('#btn_loading').hide();
						$('#login-form').find('input,button').removeAttr('disabled');
						$('input[name="password"]').val('');

						if(err.toLowerCase().includes('email')){
							$('input[name="email"]').focus();
						}else if(err.toLowerCase().includes('password')){
							$('input[name="password"]').focus();
						}

					}, 500);

			}
		});
	});

</script>
</html>
