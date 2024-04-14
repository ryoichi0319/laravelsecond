<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <title>Items</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Items</h1>

        <table class="w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="p-3 border-b border-gray-200">テーブル番号</th>
                    <th class="p-3 border-b border-gray-200">オーダーID</th>
                    <th class="p-3 border-b border-gray-200">合計金額</th>
                    <th class="p-3 border-b border-gray-200">ステータス</th>
                    <th class="p-3 border-b border-gray-200">ユーザーID</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-3 border-b border-gray-200 text-center">{{ $order->table_number }}</td>
                    <td class="p-3 border-b border-gray-200 text-center">{{ $order->id }}</td>
                    <td class="p-3 border-b border-gray-200 text-center">{{ $order->total_amount }}</td>
                    <td class="p-3 border-b border-gray-200 text-center">{{ $order->status }}</td>
                    <td class="p-3 border-b border-gray-200 text-center">{{ $order->user_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <a href="{{ route('order') }}" class="text-blue-600 underline block mx-auto mt-4 w-max">戻る</a>

    <form method="post" action="{{route('order.destroy',$order)}}"
    class=" flex-1">
     @csrf
     @method('delete')
     <x-primary-button class="bg-red-700 ml-2">
      　　　削除
     </x-primary-button>
</form>
<div class="content">
    <form action="{{ asset('charge') }}" method="POST">
        {{ csrf_field() }}
                <script
                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="{{ env('STRIPE_KEY') }}"
                        data-amount="1000"
                        data-name="Stripe Demo"
                        data-label="決済をする"
                        data-description="Online course about integrating Stripe"
                        data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                        data-locale="auto"
                        data-currency="JPY">
                </script>
    </form>
</div>
</body>
</html>
