@extends('layout.app')
@section('content')
    <h2>Board: {{$board->name}}</h2>
    <div><h3>Student: {{$user->name}} </h3></div>
    <table class="table table-striped">
        <tr>
            <form method="post" action="{{route('student.grade.store', $user->id)}}">
                @csrf
            <td><h5>Insert New Grade</h5></td>
            <td>
                <input type="number" min="1" max="10" name="grade"
                       class="form-control {{$errors->has('grade') ? 'is-invalid' : ''}}"
                       value="{{old('grade')}}">
                @if($errors->has('grade'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('grade') }}</strong>
                    </div>
                @endif
            </td>
            <td><button type="submit" class="btn btn-outline-success">Insert</button></td>
            </form>
        </tr>
        <tr>
            <th>Grade</th>
            <th>Added</th>
            <th>Delete</th>
        </tr>
        @foreach($user->grades as $grade)
            <tr>
                <td>{{$grade->grade}}</td>
                <td>{{$grade->created_at->diffForHumans()}}</td>
                <td><form action="{{route('student.grade.destroy', [$user->id, $grade->id])}}" method="post">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        <tr>
            @if($board->id === 1)
            <td>Average Grade:</td>
            <td>{{round($user->grades->average('grade'), 2)}}</td>
            <td>{{$user->grades->average('grade') < 7 ? 'Failed' : 'Passed'}}</td>
            @else
                <td>Highest Grade:</td>
                <td>{{$user->grades->max('grade')}}</td>
                <td>{{($user->grades->count() > 2 && $user->grades->max('grade') >= 8) ?
                    'Passed' : 'Failed'}}
                </td>
            @endif
        </tr>
    </table>


@endsection
