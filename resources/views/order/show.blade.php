<x-app-layout>
    <x-slot name='header'>
        <h2>
            {{-- @auth
                <h1>{{Auth::user()->name}}のオーダー</h1>
            @endauth --}}
        </h2>
    </x-slot >
    <div class="max-w-4xl mx-auto" >
        <div>
            {{ $user_id}}
        </div>
       

    </div>
</x-app-layout>