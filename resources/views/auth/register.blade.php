@extends('layout/basic')

@section('title', 'register')

@section('content')
    <h1>Register</h1>

    <form action="{{ route('register.inscription') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="box__table">
            <label for="">name :</label>
            <input type="text" name="name" placeholder="name" value="{{ old('name') }}">
        </div>
        @error('name')
            {{ $message }}
        @enderror
        <div class="box__table">
            <label for="">email :</label>
            <input type="email" name="email" placeholder="email" value="{{ old('email') }}">
        </div>
        @error('email')
            {{ $message }}
        @enderror
        <div class="box__table">
            <label for="">password :</label>
            <input type="password" name="password" placeholder="password">
        </div>
        @error('password')
            {{ $message }}
        @enderror
        <div class="box__table">
            <label for="">Image</label>
            <input type="file" name="file_image" id="">
        </div>
        @error('file_image')
            {{ $message }}
        @enderror
        <input class="btn" type="submit" value="VALIDER">
    </form>
@endsection
