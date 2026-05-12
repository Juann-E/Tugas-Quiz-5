@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">Login</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">Login</button>
        </form>
        
        <p class="text-center text-gray-600 mt-4">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar di sini</a>
        </p>
    </div>
</div>
@endsection