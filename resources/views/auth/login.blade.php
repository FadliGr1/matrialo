@extends('layouts.index')
@section('content')
<form id="loginForm" action="{{ route('login') }}" method="POST" novalidate>
    @csrf
    <div class="form-group">
        <input 
            type="text" 
            class="form-control" 
            id="email" 
            name="email" 
            placeholder="Email"
            required
            autocomplete="email">
        <i class="fas fa-user form-icon"></i>
    </div>
    
    <div class="form-group">
        <input 
            type="password" 
            class="form-control" 
            id="password" 
            name="password" 
            placeholder="Password"
            required
            autocomplete="current-password">
        <i class="fas fa-lock form-icon"></i>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input 
                type="checkbox" 
                class="form-check-input" 
                id="remember" 
                name="remember"
                value="1">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <a href="#" class="forgot-password">Forgot Password?</a>
    </div>
    
    <button type="submit" class="btn btn-login">
        <i class="fas fa-sign-in-alt me-2"></i> Sign In
    </button>
</form>

@endsection