@foreach ($users as $user)
    <option value="{{$user->id}}">{{$user->fullname}}</option>
    @endforeach
