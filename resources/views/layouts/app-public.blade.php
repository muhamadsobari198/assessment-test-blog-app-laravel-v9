<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{ env('APP_NAME') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500;1,600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" rel="stylesheet" />
    <style>
        *{
            font-family: 'Overpass', sans-serif;
        },
    </style>
</head>
<body>

<header class="bg-white top-0 w-full fixed shadow-md">
    <nav class="relative px-2 py-4">
      
    <div class="container mx-auto flex justify-between items-center">
        <span class="sidebar-brand" style="color:#606060; font-size: 21px; font-weight:800">
            <a href="{{url('/')}}" class="sidebar-brand" style="color:#606060; 
        font-size: 21px;">
                Test <span style="color:#2A8FCC;">goKampus</span>
            </a>
        </span>
        @if(Session::has('user'))
            <a href="{{route('articles')}}" class="bg-blue-400 px-3 py-1 rounded-3xl flex items-center text-white" role="button">
            <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" style="object-fit:cover;width:20px;border-radius:100px;margin-right:5px">
                <span>Hi, {{ Session::get('user')->name }}</span>
            </a>
        @else
        <a href="{{route('login')}}" class="bg-blue-400 px-5 py-1 rounded-3xl hover:bg-blue-500 text-white items-center" role="button"><i class="fa-solid fa-right-to-bracket mr-2"></i> Sign In</a>
        @endif
    </div>

    </nav>
  </header>


    @yield('content')

</body>
</html>