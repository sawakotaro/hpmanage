@extends('layout.admin')

@section('title')
@parent
サイト設定 {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/setting/site/register','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>サイト設定の{{ (Input::get('id') ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('site_name', 'サイト名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('site_name')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('domain', 'サイトドメイン', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('domain')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('company_name', '運営会社', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('company_name') ?: "未設定"}}}</div>
            </div>
            
            @if(Input::get('title'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('title', 'タイトル (SEOで使用されます)', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('title')}}}</div>
            </div>
            @endif
            
            @if(Input::get('keyword'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('keyword', 'キーワード (SEOで使用されます)', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('keyword')}}}</div>
            </div>
            @endif
            
            @if(Input::get('description'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('description', 'ディスクリプション (SEOで使用されます)', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('description')}}}</div>
            </div>
            @endif
            
            @if(Input::get('filePath'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', 'ロゴ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center"><img src='{{{Input::get('filePath')}}}' style="width: 260px;" /></div>
            </div>
            @elseif(Input::get('remove') === 'true' && Input::get('file_id', false) !== false)
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', 'ロゴ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center">
                    <div class='alert alert-warning'>ロゴ画像は削除されます</div>
                </div>
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