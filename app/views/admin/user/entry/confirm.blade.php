@extends('layout.admin')

@section('title')
@parent
会員{{ (Input::get('id') ? "編集" : "新規登録") }}フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class="col-md-6">
    {{ Form::open(array('url' => '/admin/user/entry/register','class' => '')) }}
    <fieldset class="row">
        <legend>ユーザーの{{ (Input::get('id') ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('last_name', '氏名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('last_name')}}}&nbsp;{{{Input::get('first_name')}}}</div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('last_kana', 'フリガナ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('last_kana')}}}&nbsp;{{{Input::get('first_kana')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('gender', '性別', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{!Input::get('gender', null) ? '不明' : (Input::get('gender') == 1 ? '<span class="male">男性</span>' : '<span class="female">女性</span>') }}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('birthday', '性別', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{ Input::get('birth_year') }}年&nbsp;{{ Input::get('birth_month') }}月&nbsp;{{ Input::get('birth_day') }}日&nbsp;</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('blood_type', '血液型', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('blood_type', null) ? Input::get('blood_type', null) . "型" : "未設定"}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('tel', '電話番号', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('tel')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('email', 'E-Mail', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('email')}}}</div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('password', 'パスワード', array('class' => 'control-label')) }}</div>
                <div class="panel-body">
                    <div class='alert alert-danger'>※ 表示しません</div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('registered_status', '登録ステータス', array('class' => 'control-label')) }}</div>
                <div class="panel-body">
                    @if(Input::get('registered_status') === 'formal')
                    <div class="formal">本登録</div>
                    @elseif(Input::get('registered_status') === 'interim')
                    <div class="interim">仮登録</div>
                    @else
                    <div class="withdraw">退会</div>
                    @endif
                </div>
            </div>
        
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('manager_note', '管理者メモ', array('class' => 'control-label')) }}</div>
                <div class="panel-body">
                    {{ nl2br(e(Input::get('manager_note'))) }}
                </div>
            </div>
            
            <div class="form-actions" style="text-align:center;">
                <input type="submit" name="execute" value="この内容で登録" class="btn btn-primary" />
                &emsp;
                <input type="submit" name="cancel" value="キャンセル" class="btn btn-default" />
            </div>
    </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop