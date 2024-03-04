@extends('layout/base')

@section('title', 'todos list')

@section('content')

    <div>
        @auth
            {{ Auth::user()->name }}
            <form method="POST" action="{{ route('login.logout') }}">
                @method('delete')
                @csrf
                <button>Se deconnecter</button>
                <a href="{{ route('profile.getProfile', ['id' => Auth::user()->id ]) }}">My profile</a>
            </form>
        @endauth
        @guest
            <a href="{{ route('login.index') }}">Se connecter</a>
        @endguest
    </div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <form action="{{ route('todo.store') }}" method="POST">
        @csrf
        <input name="title" type="text" placeholder="Add todo">
        <input type="submit" value="Add todo">
    </form>
    <br>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>title</th>
                <th>Created At</th>
                <th>Status</th>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>

            @if ($todos)
                @foreach ($todos as $todo)
                    <tr>
                        <td>{{ $todo->id }}</td>
                        <td>{{ $todo->title }}</td>
                        <td>{{ $todo->created_at }}</td>
                        <td>
                            @if ($todo->is_completed)
                                <div>Completed</div>
                            @else
                                <div>Pending</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('todo.edit', ['todo' => $todo->id]) }}">
                                <x-editIcon type="success" message="Edit" />
                            </a>
                            <a href="{{ route('todo.destroy', ['todo' => $todo->id]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
