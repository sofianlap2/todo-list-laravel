@extends('layout/basic')

@section('title', 'forgot password')

@section('content')
    <h1>Forgot password</h1>

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="box__table">
            <label for="">email :</label>
            <input type="email" value="{{ old('email') }}" name="email" placeholder="email">
        </div>
        @error('email')
            {{ $message }}
        @enderror

        <br>
        <a href="{{ route('login.loginIndex') }}">Return login</a>
        <br>
        <br>
        <input class="btn" type="submit" value="VALIDER">
    </form>
@endsection
