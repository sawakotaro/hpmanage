@extends('layout.admin')


@section('title')
@parent
認証ユーザー入力フォーム
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/auth/confirm','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>認証ユーザーの{{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
            <div class="form-group">
                {{ Form::label('username', 'ユーザー名', array("class" => "control-label")) }}
                {{ Form::text('username', e(Input::get('username')), array('class' => 'form-control')) }}
                @if($errors->has('username'))
                <div class="alert alert-danger">
                    {{ $errors->first('username') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('email', 'Eメールアドレス', array('class' => 'control-label')) }}
                {{ Form::text('email', e(Input::get('email')), array('class' => 'form-control')) }}
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>
            
            
            @if(Input::get('id') && !$errors->has('password'))
            <div class="text-center passwordArea">
                <button class="btn passwordBtn" type="button"> パスワードを再設定する </button>
            </div>
            
            <script type="text/javascript">
            $(function() {
                $(".password") .hide();
                $(".passwordBtn") .click(function() {
                    $(".passwordArea") .fadeOut(200, function() {
                        $(".password") .fadeIn(200);
                    });
                });
            });
            </script>
            @endif
            
            <div class="form-group password">
                {{ Form::label('password', 'パスワード', array('class' => 'control-label')) }}
                {{ Form::password('password', array('class' => 'form-control')) }}
                @if($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group password">
                {{ Form::label('password_confirmation', 'パスワード (確認用)', array('class' => 'control-label')) }}
                {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                @if($errors->has('password_confirmation'))
                <div class="alert alert-danger">
                    {{ $errors->first('retypePassword') }}
                </div>
                @endif
            </div>
            
            <div class="form-actions" style="text-align:center;">
                {{ Form::submit('入力した内容の確認',array('class'=>'btn btn-primary')) }}
            </div>
        </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop