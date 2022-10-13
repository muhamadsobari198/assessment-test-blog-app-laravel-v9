@extends('layouts.app-public')

@section('content')

@if(is_countable($articles) && count($articles) > 0)
    <div class="container mx-auto mt-20">

        <main class="text-let p-5">
            <h1 class="text-2xl">
                Latest <span class="text-blue-500"> News</span>
            </h1>
            <hr>
        </main>


        <!-- /* -------------------------------------------------------------------------- */
        /*                                First Article                               */
        /* -------------------------------------------------------------------------- */ -->
        @php
            $firstIdx = array_keys($articles->items())[0];
            $firstArticle = $articles->items()[$firstIdx];
        @endphp
    
            
        <div class="w-full p-5">  
            <div class="rounded overflow-hidden shadow-lg flex">
            <img class="w-full" src="{{ $firstArticle->image }}" style="height: 180px !important; width: 60%; object-fit: cover;">
            <div class="px-6 py-4 px-6 py-4 flex flex-col justify-between w-full">
                <div>
                    <div class="font-bold text-xl">{{ $firstArticle->title }}</div>
                    <span class="text-sm">Published <time>{{ $firstArticle->created_at ? $firstArticle->created_at->diffForHumans() : '' }}</time></span>
                    <p class="text-gray-700 text-base mt-2">{{ substr($firstArticle->content, 0, 350) }}...</p>
                </div>

                <footer class="flex justify-between items-center w-full">
                    <div class="flex items-center text-sm">
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" style="width:30px;border-radius:100px">
                        <div class="ml-3">
                            <h5 class="font-bold">
                                <a>{{ $firstArticle->createdBy->name ? $firstArticle->createdBy->name : '' }}</a>
                            </h5>
                        </div>
                    </div>

                    <div>
                        <a href="/articles/{{ $firstArticle->id }}"
                        class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8"
                        >Read More</a>
                    </div>
                </footer>
            </div>
            </div>
        </div>


        <!-- /* -------------------------------------------------------------------------- */
        /*                                   Article                                  */
        /* -------------------------------------------------------------------------- */ -->


        @if ($articles->count() > 1)
        <div class="lg:grid lg:grid-cols-6">
            @foreach ($articles->skip(1) as $article)
            
            <div class="col-span-2 p-5">  
                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                <img class="w-full" src="{{ $article->image }}" style="height: 180px !important; width: 100%; object-fit: cover;">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl">{{ $article->title }}</div>
                    <span class="text-sm">Published <time>{{ $article->created_at ? $article->created_at->diffForHumans() : '' }}</time></span>
                    <p class="text-gray-700 text-base mt-2">
                    {{ substr($article->content, 0, 150) }}...
                    </p>
                </div>
                <div class="px-6 mb-6">
                <footer class="flex justify-between items-center">
                    <div class="flex items-center text-sm">
                        <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" style="width:30px;border-radius:100px">
                        <div class="ml-3">
                            <h5 class="font-bold">
                                <a>{{ $article->createdBy->name ? $article->createdBy->name : '' }}</a>
                            </h5>
                        </div>
                    </div>

                    <div>
                        <a href="/articles/{{ $article->id }}"
                        class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8"
                        >Read More</a>
                    </div>
                </footer>
                </div>
                </div>
            </div>
            
            @endforeach
        </div>
        @endif

        <div class="p-5">
            {{ $articles->links() }}
        </div>
    </div>
@else
    <div class="text-2xl font-bold text-center text-gray-800 md:text-3xl flex flex-col justify-center items-center bg-blue-50" style="height:calc(100vh - 14vh);">
        <span class="text-red-600"><i class="fa-solid fa-close"></i> Oops!</span>Tidak Artikel yang ditemukan
    </div>
@endif
@endsection