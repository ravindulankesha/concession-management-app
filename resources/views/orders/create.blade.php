@include('navBar')
<body>
    <div class="form-container">
        <h1>Create Order</h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="concessions">Select Concessions</label>
                <div class="checkbox-list">
                    @foreach ($concessions as $concession)
                        <label class="checkbox-item">
                            <input type="checkbox" name="concessions[]" value="{{ $concession->id }}">
                            {{ $concession->name }} - ${{ $concession->price }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="send_to_kitchen_time">Send to Kitchen Time</label>
                <input type="datetime-local" id="send_to_kitchen_time" name="send_to_kitchen_time" required>
            </div>
            <div class="form-group">
                <button type="submit">Create Order</button>
            </div>
        </form>
    </div>
</body>
</html>
