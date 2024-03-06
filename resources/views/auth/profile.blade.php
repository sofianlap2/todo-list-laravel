@extends('layout/base')

@section('title', 'profile')

@section('content')
    <form action="{{ route('profile.updateProfile', ['id' => $user->id]) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
        <label for="">name :</label>
        <input type="text" name="name" placeholder="name" value="{{ $user->name }}">
        @error('name')
            {{ $message }}
        @enderror
        <br>
        <label for="">email :</label>
        <input type="email" name="email" placeholder="email" value="{{ $user->email }}">
        @error('email')
            {{ $message }}
        @enderror
        <br>
        {{--<label for="">password :</label>
        <input type="password" name="password" placeholder="password">
        @error('password')
            {{ $message }}
        @enderror--}}
        <br>
        <label for="">Image</label>
        <input type="file" name="file_image" id="">
        <br>
        @if($user->image)
        <img width="300" height="300" src="/storage/{{ $user->image }}" alt="img" >
        @endif
        @error('image')
            {{ $message }}
        @enderror
        <br>
        <input class="btn" type="submit" value="VALIDER">
    </form>
@endsection
