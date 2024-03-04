@extends('layout/base')

@section('title', 'register')

@section('content')
    <h1>Register</h1>

    <form action="{{ route('register.inscription') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="">name :</label>
        <input type="text" name="name" placeholder="name" value="{{ old('name') }}">
        @error('name')
        {{ $message }}
        @enderror
        <br>
        <label for="">email :</label>
        <input type="email" name="email" placeholder="email" value="{{ old('email') }}">
        @error('email')
        {{ $message }}
        @enderror
        <br>
        <label for="">password :</label>
        <input type="password" name="password" placeholder="password">
        @error('password')
        {{ $message }}
        @enderror
        <br>
        <label for="">Image</label>
        <input type="file" name="file_image" id="">
        @error('file_image')
        {{ $message }}
        @enderror
        <br>
        <input type="submit" value="VALIDER">
    </form>
@endsection
