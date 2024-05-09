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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="container mx-auto py-6">
        <h1 class="text-2xl mb-6">Items</h1>
        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">名前</th>
                    <th class="p-3 text-left">数</th>
                    <th class="p-3 text-left">@sortablelink('order_id', 'オーダーID')</th>
                    <th class="p-3 text-left">@sortablelink('status', '状態')</th>
                    <th class="p-3 text-left">@sortablelink('price', '価格')</th>
                    <th class="p-3 text-left">@sortablelink('created_at', 'オーダー順')</th>
                    <th class="p-3 text-left">アクション</th>
                </tr>
            </thead>
            <tbody>
                @php $orderTotals = []; @endphp
                @foreach($items as $item)
                    @php
                        $totalAmount = $item->quantity * $item->price;
                        $orderTotals[$item->order_id] = ($orderTotals[$item->order_id] ?? 0) + $totalAmount;
                    @endphp
                    <tr class="border-b border-gray-300 hover:bg-gray-100">
                        <td class="p-3">{{$item->name}}</td>
                        <td class="p-3">{{$item->quantity}}</td>
                        <td class="p-3">{{$item->order_id}}</td>
                        <td class="p-3">{{$item->status}}</td>
                        <td class="p-3 text-center">{{number_format($totalAmount)}}円</td>
                        <td class="p-3">{{$item->created_at}}</td>
                        <td class="p-3">
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
                        <td class="p-3" colspan="2"><strong>Total for Order {{$orderId}}:</strong></td>
                        <td class="p-3">{{ $total }}</td>
                        <div>
                            @php
                                $test = "aaa";
                                echo '$test'."$test";
                            @endphp
                        </div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
