<x-app-layout>
    <x-slot name='header'>
    </x-slot>
<body>
    <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate('https://hotpepperapi1201.vercel.app/')) !!} ">

    <h1>Create Order</h1>
    
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <label for="table_number">テーブルナンバー : </label>
        <x-input-error :messages="$errors->get('table_number')" />
        <input type="number" name="table_number" value="1" >
        <x-primary-button>
            送信
        </x-primary-button>
    </form>
    

</x-app-layout>
