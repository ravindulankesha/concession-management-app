@include('navBar')
<body>
    <div class="container">

        <h1>Orders</h1>

        @if($orders->isEmpty())
            <p>No orders found.</p>
        @else
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Concessions</th>
                        <th>Send to Kitchen Time</th>
                        <th>Status</th>
                        <th>Total Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <ul>
                                    @foreach ($order->concessions as $concession)
                                        <li>{{ $concession->name }} - ${{ $concession->price }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $order->send_to_kitchen_time }}</td>
                            <td>{{ $order->status }}</td>
                            <td>Rs.{{ $order->concessions->sum('price') }}</td>
                            <td>
                                @if ($order->status == 'Pending')
                                <form action="{{ route('kitchen.send', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn edit">Send to Kitchen</button>
                                </form>
                                @endif
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
