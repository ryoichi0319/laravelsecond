<x-app-layout>
    <x-slot name="header">
        <h1>aaa</h1>
    </x-slot>
    @foreach($fruits as $f)
        {{ $f }}
    @endforeach
    <x-primary-button>
        ボタン
    </x-primary-button>
    <x-danger-button>
        ボタン
    </x-danger-button>
    <x-dropdown  width="48" contentClasses="py-1 bg-white">
        <!-- トリガー -->
        <x-slot name="trigger">
            <x-primary-button>
             トリガーボタン
            </x-primary-button>
        </x-slot>
    
        <!-- ドロップダウンの内容 -->
        <x-slot name="content">
            <!-- メニュー項目 -->
        <ul class="list-none p-0">
            <x-dropdown-link href="{{ route('dashboard') }}" >
                    <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">メニュー項目1</li>
            </x-dropdown-link >
            <x-dropdown-link href="{{ route('test')}}">
                    <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">メニュー項目2</li>
            </x-dropdown-link>
            <x-dropdown-link >
                <li class="py-2 px-4 hover:bg-gray-100 cursor-pointer">メニュー項目3</li>
            </x-dropdown-link>
        </ul>
        </x-slot>
    </x-dropdown>
    <x-text-input >
    </x-text-input>
    <x-nav-link href="{{ route('test')}}">
        asdf
    </x-nav-link>
    <x-nav-link :href="route('dashboard')">
        asdf
    </x-nav-link>
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('test')">
        {{ __('Dashboard') }}
   </x-nav-link>

   @foreach($users as $user)
   <p>
    {{ $user->name }}
   </p>
   @endforeach

   
   

   
</x-app-layout>
