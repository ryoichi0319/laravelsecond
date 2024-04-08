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
    <h1 class="">Items</h1>

    <table>
        <thead>
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Price</th>
                <th class="p-3">Quantity</th>
                <th class="p-3">Order ID</th>
                <th class="p-3">Status</th>
                <th class="p-3">Total Amount</th>
                <th class="p-3">created at</th>

            </tr>
        </thead>
        <tbody>
            @php
            $orderTotals = [];
        @endphp
        
        @foreach($items as $item)
            @php
                // 各order_idごとのtotal_amountを計算
                $totalAmount = $item->quantity * $item->price;
                // 各order_idに対するtotal_amountを累積 処理してない同じorder_ideには０をつけておく
                $orderTotals[$item->order_id] = ($orderTotals[$item->order_id] ?? 0) + $totalAmount
            @endphp
                <tr class=" ">
                    <td class="p-3 text-right">{{ $item->name }}</td>
                    <td class="p-3 text-right">{{ $item->price }}</td>
                    <td class="p-3 text-right">{{ $item->quantity }}</td>
                    <td class="p-3 text-right">{{ $item->order_id }}</td>
                    <td class="p-3 text-right">{{ $item->status }}</td>
                    <td class="p-3 text-right">{{ $totalAmount }}</td>
                    <td class="p-3 text-right">{{ $item->created_at }}</td>
                    <td>
                        <form action="{{ route('item.update', $item) }}" method="post">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="status" value="pending">Pending</button>
                            <button type="submit" name="status" value="processing">Processing</button>
                            <button type="submit" name="status" value="completed">Completed</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            @foreach($orderTotals as $orderId => $total)
                <tr>
                    <td colspan="5"></td>
                    <td class="p-3"><strong>Total for Order {{ $orderId }}:</strong></td>
                    <td class="p-3">{{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
