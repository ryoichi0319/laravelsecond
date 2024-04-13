<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            メール
        </h2>
    </x-slot>
<form method="POST" id="sendMailForm" action="{{ route('send_mail') }}" class="">
    @csrf
    @php
                $disabled = session()->has('message') && session('message') == '送信しました'
    @endphp
    <x-primary-button type="submit" class="ml-3" :disabled="$disabled" >送信</x-primary-button>
    @if(session('message'))
    <div>{{ session('message') }}</div>
@endif
</form>
<!-- Blade コンポーネントの使用例 -->
<x-dropdown align="right" width="48">
    <!-- トリガー要素 -->
    <x-slot name="trigger">
        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
            <div>{{ Auth::user()->name }}</div>
            <div class="ms-1">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </x-slot>
    
    <!-- ドロップダウンメニューのコンテンツ -->
    <x-slot name="content">
        <x-dropdown-link :href="route('profile.edit')">
            {{ __('Profile') }}
        </x-dropdown-link>
        <!-- ログアウトリンク -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-dropdown-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
    </x-slot>
</x-dropdown>

</x-app-layout>