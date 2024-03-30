<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @auth
            <h1>{{ Auth::user()->name }}のクイズページ</h1>
            @endauth
        </h2>
    </x-slot>
    <div class="mt-4 p-8 bg-white w-full rounded-2xl max-w-4xl mx-auto ">

   
    <div class="  flex justify-center items-center "> 
        <p class=" ">クイズは全部で</p>
           <p class=" text-red-500 font-bold text-3xl "> {{$total_quiz}}</p>
        <p class="mr-5">問です。</p>
           

        <a href="{{ route('order/create') }} >
            <div class=" gap-3 flex ">
        <x-primary-button>
        スタート
      </x-primary-button>
      
      @if(Auth::user()->role == 'admin')
      <a href="http://localhost:8080">
            <x-secondary-button>
                クイズを作る
            </x-secondary-button>
        </a>
      @endif
      </div>

    </a>
    </a>
        
    </div>
    </div>
</x-app-layout>           
