<ul class="timeline">
    @php ($i = 1)
    @foreach($traza as $t)
        @if($i % 2)
            <li>
        @else
            <li class="timeline-inverted">
        @endif    
            
                <div class="timeline-badge"><i class="glyphicon glyphicon-hourglass" rel="tooltip" title='{{ $t["fecha"]["descripcion"] }}' id=""></i></div>
                    <div class="timeline-panel">
                        <div class="timeline-body">
                            <p>{{ $t["fecha"]["titulo"] }} : {{ $t["fecha"]["descripcion"] }}</p>
                            <p>{{ $t["estado"]["titulo"] }} : {{ $t["estado"]["descripcion"] }}</p>
                            <p>{{ $t["codigo"]["titulo"] }} : {{ $t["codigo"]["descripcion"] }}</p>
                            <p>{{ $t["destino"]["titulo"] }} : {{ $t["destino"]["descripcion"] }}</p>
                            <p>{{ $t["observaciones"]["titulo"] }} : {{ $t["observaciones"]["descripcion"] }}</p>
                        </div>
                    </div>
            </li>
        @php ($i++)
    @endforeach
        <li class="clearfix" style="float: none;"></li>
    
</ul>