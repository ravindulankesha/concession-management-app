<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="{{ route('concessions.index') }}" class="nav-item">View Concessions</a>
        <a href="{{ route('concessions.create') }}" class="nav-item">Create Concessions</a>
        <a href="{{ route('orders.index') }}" class="nav-item">View Orders</a>
        <a href="{{ route('orders.create') }}" class="nav-item">Create Orders</a>
        <a href="{{ route('kitchen.index') }}" class="nav-item">Kitchen</a>
    </div>
</nav>
