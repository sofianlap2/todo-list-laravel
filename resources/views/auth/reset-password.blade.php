@extends('layout/basic')

@section('title', 'forgot password')

@section('content')
    <h1>Forgot password</h1>

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <div class="box__table">
            <label for="">email :</label>
            <input type="email" name="email" placeholder="email">
        </div> @error('email')
            {{ $message }}
        @enderror
        <div class="box__table">
            <label for="">password :</label>
            <input type="password" name="password" placeholder="password">
        </div> @error('password')
            {{ $message }}
        @enderror
        <div class="box__table">
            <label for="">password_confirmation :</label>
            <input type="password_confirmation" name="password_confirmation" placeholder="password_confirmation">
        </div> @error('password_confirmation')
            {{ $message }}
        @enderror

            <input type="hidden" name="token">


        <br>
        <input class="btn" type="submit" value="VALIDER">
    </form>
@endsection