@extends('layout/base')

@section('title', 'edit todo')

@section('content')
<h1>Edit todo</h1>
<form action="{{ route('todo.update', ['todo' => $todo->id]) }}" method="POST">
    @csrf
    @method('put')

    <input name="title" type="text" name="title" value="{{ $todo->title }}">
    <label for="">Completed :</label>
    @if ($todo->is_completed == true)
        <input checked type="radio" value="1" name="is_completed" id=""><label
            for="">Completed</label>
    @else
        <input type="radio" value="1" name="is_completed" id=""><label for="">Completed</label>
    @endif

    @if ($todo->is_completed == false)
        <input checked type="radio" value="0" name="is_completed" id=""><label
            for="">Pending</label>
    @else
        <input type="radio" value="0" name="is_completed" id=""><label for="">Pending</label>
    @endif

    <input class="btn" type="submit" value="Valider">
</form>
@endsection