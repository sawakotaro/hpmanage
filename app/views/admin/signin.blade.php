<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>HP-Manager サインイン</title>

    {{HTML::style("//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css")}}
    {{HTML::style("/css/signin.css")}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      
      {{ Form::open(array('class' => 'form-signin', 'url' => '/admin/signin')) }}
      <fieldset>
        <legend>管理画面 サインイン</legend>
        @if($errors->has('signin'))
        <div class="alert alert-danger">
        {{ $errors->first('signin') }}
        </div>
        @endif
        
        
        <div class="form-group">
            {{ Form::text('email', Input::old('email', ''), array('class' => 'form-control', 'placeholder' => 'Eメールアドレス', 'autofocus' => 'autofocus')) }}
            @if($errors->has('email'))
            <div class="alert alert-danger">
            {{ $errors->first('email') }}
            </div>
            @endif
        </div>
        
        
        <div class="form-group">
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'パスワード')) }}
            @if($errors->has('password'))
            <div class="alert alert-danger">
            {{ $errors->first('password') }}
            </div>
            @endif
        </div>
        
        {{Form::hidden('suspended', '0')}}
        {{ Form::submit('サインイン', array('class' => 'btn btn-lg btn-primary btn-block')) }}
      {{ Form::token() }}
      
      </fieldset>
      {{ Form::close() }}
    </div> <!-- /container -->


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
 {{HTML::script("https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js")}}
 <!-- Include all compiled plugins (below), or include individual files as needed -->
 {{HTML::script("//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js")}}
 </body>
</html>