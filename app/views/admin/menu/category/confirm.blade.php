@extends('layout.admin')

@section('title')
@parent
カテゴリ設定 {{ (Input::get('id', "") !== "" ? "編集" : "新規登録") }}フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/menu/category/register','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>カテゴリ設定の{{ (Input::get('id', "") !== "" ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            
            @if(Input::get('id', '') === '')
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('parent_category_name', '関連カテゴリ名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{$parent_category_name ? $parent_category_name : "TOPカテゴリとして登録します"}}}</div>
            </div>
            @endif
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('category_name', 'カテゴリ名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('category_name')}}}</div>
            </div>
            
            @if(Input::get('memo'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('memo', 'メモ', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('memo')}}}</div>
            </div>
            @endif
            
            
            @if(Input::get('filePath'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', 'カテゴリ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center"><img src='{{{Input::get('filePath')}}}' style="width: 260px;" /></div>
            </div>
            @elseif(Input::get('remove') === 'true' && Input::get('file_id', false) !== false)
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', 'カテゴリ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center">
                    <div class='alert alert-warning'>カテゴリ画像は削除されます</div>
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