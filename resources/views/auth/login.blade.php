@extends('layouts.app')

@section('content')
<div class="container col-md-4">
    <h3 class="mb-4">Login</h3>

    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('register') }}">New student? Register here</a>
    </div>
</div>
@endsection
