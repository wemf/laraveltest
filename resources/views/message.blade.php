@if(Session::has('success'))     
    <div class="alert alert-success">
        <strong>{{ Session::get('success')}}</strong>               
    </div>          
@endif
@if (count($errors)>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
@if(Session::has('error'))     
    <div class="alert alert-danger">
        <strong>{{ Session::get('error')}}</strong>               
    </div>          
@endif