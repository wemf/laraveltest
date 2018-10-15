@inject('notis', 'App\Notificacion')
<li role="presentation" class="dropdown">
    <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-envelope-o"></i>
    <span class="badge bg-green">{{count($notis->getMensajes())}}</span>
    </a>
    <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
    @if(count($notis->getMensajes())>0)
        @foreach ($notis->getMensajes() as $noti)
        <li>
            <a href="javascript:void(0)" data-id="{{$noti->id}}" onclick="noti.vistoMenuAction(this)">
            <span class="image"><i class="fa fa-envelope"></i></span>
            <span>
                <span>{{$noti->Nombre_Usurio_Emisor}}</span>
                <span class="time">{{$noti->Fecha}}</span>
            </span>
            <span class="message">
                {{$noti->mensaje}} 
            </span>
            </a>
        </li>
        @endforeach
    @else
        <li>
            <a>
            <span class="image"><i class="fa fa-envelope"></i></span>
            <span>
                <span></span>
                <span class="time"></span>
            </span>
            <span class="message">
                No tiene mensajes por ver! 
            </span>
            </a>
        </li>
    @endif
    <li>
        <div class="text-center">
        <a href="{{route('mensajes.index')}}">
            <strong>Todos los mensajes</strong>
            <i class="fa fa-angle-right"></i>
        </a>
        </div>
    </li>
    </ul>
</li>