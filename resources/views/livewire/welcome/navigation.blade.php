<div class="sm:fixed sm:top-0 sm:right-0 p-6 text-end z-10">
    @auth
        <a href="{{ url('/posts') }}" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500" wire:navigate>Home</a>
        @else
        <a href="{{ route('login') }}" class="font-bold text-gray-800 bg-green-400 hover:bg-green-500 px-6 py-3 rounded-md mr-4" style="background-color: #B197FC;">Log in</a>
        
        @if (Route::has('register'))
            <a href="{{ route('register') }}" class="font-bold text-gray-800 bg-yellow-400 hover:bg-yellow-500 px-6 py-3 rounded-md" style="background-color: #FFD43B;">Register</a>
        @endif
    @endauth
</div>
