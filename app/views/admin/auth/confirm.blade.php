@extends('layout.admin')

@section('title')
@parent
認証ユーザー入力フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/auth/execute','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>認証ユーザーの{{ (Input::get('id') ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('username', 'ユーザー名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('username')}}}</div>
            </div>
            
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('email', 'Eメールアドレス', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{e(Input::get('email'))}}</div>
            </div>
            
            @if(Input::get('password'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('password', 'パスワード', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{StringUtil::changeAllForString(Input::get('password'), "●")}}</div>
            </div>
            @endif
            
            <div class="form-actions" style="text-align:center;">
                <input type="submit" name="execute" value="この内容で登録" class="btn btn-primary" />
                &emsp;
                <input type="submit" name="cancel" value="キャンセル" class="btn btn-default" />
            </div>
        </fieldset>
    
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop