<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
</head>
<body>
    <h1>Items</h1>

    <table>
        <thead>
            <tr>
                <th class="p-3">Name</th>
                <th class="p-3">Quantity</th>
                <th class="p-3">Order ID</th>
                <th class="p-3">status</th>


            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="p-3">{{ $item->name }}</td>
                    <td class="p-3">{{ $item->quantity }}</td>
                    <td class="p-3">{{ $item->order_id }}</td>
                    <td class="p-3">{{ $item->status}}</td>
                    <td>
                        <form action="{{ route('item.store', ['id' => $item->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="status" value="processing">Processing</button>
                            <button type="submit" name="status" value="completed">Completed</button>
                        </form>
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
