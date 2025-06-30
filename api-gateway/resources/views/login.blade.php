@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h2>Login</h2>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="/api/auth/login">
        @csrf
        <input type="email" name="email" placeholder="Email" class="form-control mb-2" required />
        <input type="password" name="password" placeholder="Password" class="form-control mb-2" required />
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <a href="/register">Belum punya akun?</a>
@endsection