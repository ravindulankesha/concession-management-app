@include('navBar')
<body>
    <div class="container">
        <h1>All Concessions</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($concessions as $concession)
                    <tr>
                        <td>{{ $concession->name }}</td>
                        <td>{{ $concession->description }}</td>
                        <td><img src="{{ asset('storage/' . $concession->image) }}" alt="{{ $concession->name }}" width="100"></td>
                        <td>Rs.{{ $concession->price }}</td>
                        <td>
                            <form action="{{ route('concessions.edit', $concession->id) }}" method="GET" style="display: inline;">
                                <button type="submit" class="btn edit">Edit</button>
                            </form>
                            <form action="{{ route('concessions.destroy', $concession->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn delete" onclick="return confirm('Are you sure you want to delete this concession?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
