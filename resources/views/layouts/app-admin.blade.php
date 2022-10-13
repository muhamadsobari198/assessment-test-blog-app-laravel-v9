<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }} @yield('title')</title>
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  	

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
   
</body>
<script>
</script>

@yield('js')

</html>