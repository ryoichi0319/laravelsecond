<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <h1>Create Order</h1>
    
    <form action="{{ route('order.store') }}" method="post">
        @csrf
        <label for="table_number">テーブルナンバー : </label>
        <x-input-error :messages="$errors->get('table_number')" />
        <input type="number" name="table_number" value="1" >
        <x-primary-button>
            送信
        </x-primary-button>
    </form>
    
</body>
</html>