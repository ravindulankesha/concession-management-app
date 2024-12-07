@include('navBar')

<body>
    <div class="form-container">
        <h1>Edit Concession</h1>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        <form action="{{ route('concessions.update', $concession->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $concession->name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required>{{ old('description', $concession->description) }}</textarea>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" id="image" name="image" accept="image/*">
                @if($concession->image)
                    <div><img src="{{ asset('storage/' . $concession->image) }}" alt="Concession Image" width="100"></div>
                @endif
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="{{ old('price', $concession->price) }}" step="0.01" required>
            </div>
            <div class="form-group">
                <button type="submit">Update Concession</button>
            </div>
        </form>
    </div>
</body>
</html>
