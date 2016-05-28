@extends('layout.admin')

@section('title')
@parent
動画コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム 入力内容のご確認
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/contents/movie/register','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>動画コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }} 入力内容のご確認</legend>
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('tag', 'タグ', array("class" => "control-label")) }}</div>
                <div class="panel-body">
                    @foreach($tagList as $tag)
                    <button class="btn btn-sm btn-success" disabled="disabled">{{{$tag}}}</button>
                    @endforeach
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('title', 'タイトル', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('title')}}}</div>
            </div>
            
            @if(Input::get('description'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('description', '記事詳細', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{Input::get('description')}}}</div>
            </div>
            @endif
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('postedAt', '投稿日時', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{{$postedAt}}}</div>
            </div>
            
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('movieScriptTag', '動画埋め込みタグ', array('class' => 'control-label')) }}</div>
                <div class="panel-body">{{Input::get('movieScriptTag')}}</div>
            </div>
            
            <div class="space-top-20 col-md-12">
                {{ (intval(Input::get('suspended')) === 0) ? "<div class='alert alert-success'>このコンテンツは公開されます</div>" : "<div class='alert alert-danger'>このコンテンツは非公開です</div>"}}
            </div>
            
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