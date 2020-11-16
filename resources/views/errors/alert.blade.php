@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

@endif

@if(session('msg'))
    <div class="alert alert-success">
        <li>{{session('msg')}}</li>
    </div>
@endif

@if(session('err'))
    <div class="alert alert-danger">
        <li>{{session('err')}}</li>
    </div>
@endif