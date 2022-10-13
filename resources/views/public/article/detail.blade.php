@extends('layouts.app-public')

@section('content')

<div class="container mx-auto mt-20">
    <div class="w-full p-5">  
        <div class="w-full rounded overflow-hidden shadow-lg">
        <img class="w-full" src="{{ url($article->image) }}" style="height: 300px !important; width: 100%; object-fit: cover;">
        <div class="px-6 py-4">
            <div class="font-bold text-xl">{{ $article->title }}</div>
            <span class="text-sm">Published <time>{{ $article->created_at ? $article->created_at->diffForHumans() : '' }}</time></span>
            <p class="text-gray-700 text-base mt-2">
            {{$article->content}}
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
            <a href="{{url('/')}}"
                class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8"
                >Back</a>
            </div>
        </footer>
        </div>
        </div>
    </div>
</div>

@endsection