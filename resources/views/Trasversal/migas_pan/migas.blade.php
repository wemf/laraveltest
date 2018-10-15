<div class="wrapper col-md-10 col-lg-10 col-sm-8 col-xs-6"> 
  <ul class="breadcrumbs">
    @foreach ($urls as $link)
        @if ($loop->first)        
            @if($loop->last)
                <li class="last active"><a href="{{url('/')}}/{{$link['href']}}" class="fa fa-home"></a></li>
            @else
                <li class="first"><a href="{{url('/')}}/{{$link['href']}}" class="fa fa-home"></a></li>                
            @endif
        @else
            @if($loop->last)
                <li class="last active"><a href="{{url('/')}}/{{$link['href']}}">{{$link['text']}}</a></li> 
            @else
                <li><a href="{{url('/')}}/{{$link['href']}}">{{$link['text']}}</a></li>             
            @endif   
        @endif
    @endforeach  
  </ul>
</div>