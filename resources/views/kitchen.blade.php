@include('navBar')
    <div class="container">
        <h1>Orders</h1>

        @if($orders->isEmpty())
            <p>No orders Sent to kitchen.</p>
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
                                @if ($order->status != 'Completed')
                                <form action="{{ route('kitchen.updateStatus', $order->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn edit">Mark status as completed</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
