@extends('layout/basic')

@section('title', 'login')

@section('content')
    <h1>Login</h1>

    <form action="{{ route('login.doLogin') }}" method="POST">
        @csrf
        <div class="box__table">
            <label for="">email :</label>
            <input type="email" value="{{ old('email') }}" name="email" placeholder="email">
        </div>
        @error('email')
            {{ $message }}
        @enderror
        <br>
        <div class="box__table">
            <label for="">password :</label>
            <input type="password" name="password" placeholder="password">
        </div> @error('password')
            {{ $message }}
        @enderror
        <br>
        <a href="{{ route('register.index') }}">Create new account ?</a>
        <br>
        <br>
        <input class="btn" type="submit" value="VALIDER">
    </form>
@endsection
