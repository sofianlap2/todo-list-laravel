@extends('layout/base')

@section('title', 'login')

@section('content')
    <h1>Login</h1>

    <form action="{{  route('login.doLogin') }}" method="POST">
        @csrf
        <label for="">email :</label><input type="email" value="{{ old('email') }}" name="email" placeholder="email">
        @error('email')
        {{ $message }}
        @enderror
        <br>
        <label for="">password :</label><input type="password" name="password" placeholder="password">
        @error('password')
        {{ $message }}
        @enderror
        <br>
        <a href="{{ route('register.index') }}">Create new account ?</a>
        <br>
        <br>
        <input type="submit" value="VALIDER">
    </form>
@endsection