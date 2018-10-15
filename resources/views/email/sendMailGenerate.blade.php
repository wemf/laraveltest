<html>
    <head>
<style>

    .body_correo{
        width: 50%;
        margin: 3% auto;
        box-shadow: 0px 1px 8px 0px #777373 !important;
    }

    .body_correo .cont_body_correo{
        margin: 5%;
    }

    .body_correo .cont_body_correo p{
        text-align: justify;
    }

    .body_correo .cont_body_correo h1{
        font-size: 1.8em;
        text-align: justify;
    }
    .body_correo .cont_body_correo .pie{
        margin-top: 10%;
    }

    .body_correo .cont_body_correo .pie img{
        width: 10%;
    }

    .body_correo .cont_body_correo .pie p{
        margin: 0 5%;
    }

    .body_correo .cont_body_correo .pie span{
        font-size: 1.9em;
        font-family: "Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif;
    }
</style>
</head>
<body>
<div class="content_correo">
    <div class="body_correo" style="box-shadow: 0px 1px 8px 0px #777373;">
        <div class="cont_body_correo">
            {!!html_entity_decode($body)!!}
            <div class="pie">
                <img src="http://dws.solutions/nutibara/dev/public/images/logo.png" alt=""><span>SINNUT</span>
                <p>Sistema de información negocios nutibara</p>
                <p>{{ $tienda }}</p>
            </div>
        </div>    
    </div>
</div>
</body>
<html>