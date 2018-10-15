@extends('layouts.master')

@section('content')

  <div class="center"> 
      <h1 class="titulo">Usuarios en linea</h1> 
      @if($users)
        @foreach($users as $user)
            @if($user->isOnline())
                <li>{{ $user->name }}</li>
            @endif
        @endforeach
      @endif
  </div>
    
@endsection

@push('scripts')
@endpush

@section('javascript')
    @parent
@endsection