@extends('layout.app')
@section('content')
    <div><h1>{{$board->name}} Board</h1></div>
    <table class="table table-striped">
        <tr>
            <form method="post" action="{{route('board.student.store', $board->id)}}">
                @csrf
                <td>New student</td>
                <td colspan="3">
                    <input type="text" name="name" placeholder="Insert Student Name"
                           class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}"
                           value="{{old('name')}}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                    @endif
                </td>
                <td>
                    <button type="submit" class="btn btn-outline-secondary">Create</button>
                </td>
            </form>
        </tr>
        <tr><th>id</th><th>Name</th><th>Average grade</th><th>Export data</th><td>Delete student</td></tr>
        @foreach($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td><a href="{{route('board.student.show', [$board->id, $user->id])}}">{{$user->name}}</a></td>
            <td>{{round($user->grades->average('grade'), 2)}}</td>
            <td><a class="btn btn-outline-secondary btn-sm" href="{{route('board.student.show', [$board->id, $user->id])}}">Show Student</a></td>
            <td><form method="post" action="{{route('board.student.destroy', [$board->id, $user->id])}}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
                </form>

        </tr>
        @endforeach
    </table>
    <div class="text-center">
        @if($board->id === 1)
            <a href="1/export" class="btn btn-primary">Export to JSON</a>
        @else
            <a href="2/export" class="btn btn-primary">Export to XML</a>
        @endif
    </div>
@endsection
