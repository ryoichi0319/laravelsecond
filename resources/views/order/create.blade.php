<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
</head>
<body>
    <h1>Create Order</h1>
    
    <p>Table Number:</p>
    <form action="{{ route('order.store') }}" method="post">
        @csrf
        <input type="number" name="table_number" value="1" >
        <x-primary-button>
            送信
        </x-primary-button>
    </form>
    
</body>
</html>