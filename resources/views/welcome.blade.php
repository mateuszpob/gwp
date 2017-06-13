<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GWP</title>

    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {!! Form::open(array('action' => 'UrlCheckController@uploadFile', 'class' => 'form', 'files' => true)) !!}
            {!! csrf_field() !!}

            {!! Form::file('yaml_file') !!}


            {!! Form::submit('Ok', array('class'=>'btn btn-primary')) !!}

            {!! Form::close() !!}
        </div>
    </body>
</html>
