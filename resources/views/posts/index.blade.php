<!-- resources/views/posts/index.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div>
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <div class="form-group" style="display: flex">
                                <div class="flex-shrink-0" style="
                                display: flex;
                                height: 50px;
                                width: 50px;
                                border-radius: 50%;
                                background: #FFD43B;
                                justify-content: space-around;
                                align-items: center;
                                margin-right: 20px;">
                            <x-application-logo class="w-8 h-8"/>

                        </div>
                            <textarea name="content" class="form-control block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('content') is-invalid @enderror" rows="3" placeholder="What's on your mind?" required></textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mt-2" style="display: flex; justify-content: flex-end;">
                            <x-primary-button class="ms-3" style="margin: 0">
                                {{ __('Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                <div>
                    @foreach($posts as $post)
                    <div class="post p-4 bg-white shadow-md rounded-lg" style="margin-bottom: 20px">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0" style="display: flex;
                                height: 30px;
                                width: 30px;
                                border-radius: 50%;
                                background: #FFD43B;
                                justify-content: space-around;
                                align-items: center;">
                                <x-application-logo class="w-5 h-5"/>

                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">{{ $post->user->name }}</div>
                                <p class="text-gray-600 mt-2">{{ $post->content }}</p>
                                <div class="text-sm text-gray-500 mt-2">{{ $post->created_at->format('h:i A - d M, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
