@extends('layout.admin')


@section('title')
@parent
動画コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム
@stop

@section('content')

{{HTML::style("/lib/tagit/jquery.tagit.css")}}
{{HTML::style("/lib/tagit/tagit.ui-zendesk.css")}}
{{HTML::script("/lib/tagit/tagit.min.js")}}

<script type="text/javascript">
$(function() {
    // tagit
    $('#tags').tagit();
    
});
</script>

<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/contents/movie/confirm', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) }}
        <fieldset>
            <legend>動画コンテンツ {{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
            <div class="alert alert-warning">
                <span class="important">※</span>は必須項目<br />
                タグにカンマは含めないでください。
            </div>
            
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <span class="important">※ </span>
                    {{Form::label('tag', 'タグ', array('class' => 'control-label'))}}
                </div>
                
                <div class="col-sm-9">
                    {{Form::text("tag", Input::get('tag', null), array('class' => 'form-control', 'id' => 'tags'))}}
                    @if($errors->has('tag'))
                    <div class="alert alert-danger">
                        {{ $errors->first('tag') }}
                    </div>
                    @endif
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <span class="important">※ </span>
                    {{ Form::label('title', 'タイトル', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    {{ Form::text('title', e(Input::get('title')), array('class' => 'form-control', 'placeholder' => 'タイトルを入力')) }}
                    @if($errors->has('title'))
                    <div class="alert alert-danger">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    {{ Form::label('description', '記事詳細', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    {{ Form::textarea('description', e(Input::get('description')), array('class' => 'form-control')) }}
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                {{ Form::label('suspended', '表示状態', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    <label>{{ Form::radio('suspended', 0, intval(Input::get('suspended')) === 0 ? true : false) }} 公開</label>
                    &emsp;
                    <label>{{ Form::radio('suspended', 1, intval(Input::get('suspended')) === 1 ? true : false) }} 非公開</label>
                </div>
            </div>
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                {{ Form::label('posted_at', '投稿日時', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    <div>
                        {{ Form::select("year", $dateList['year'], $postedValueList['year'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}年
                        {{ Form::select("month", $dateList['month'], $postedValueList['month'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}月
                        {{ Form::select("day", $dateList['day'], $postedValueList['day'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}日<br />
                    </div>
                    <div class="space-top-10">
                        {{ Form::select("hour", $dateList['hour'], $postedValueList['hour'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}時
                        {{ Form::select("minute", $dateList['minute'], $postedValueList['minute'], array("class" => "form-control", "style" => "width: auto; display: inline;")) }}分
                    </div>
                </div>
            </div>
            
            
            
            
            
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    {{ Form::label('movieScriptTag', '動画埋め込みタグ', array("class" => "control-label")) }}
                </div>
                
                <div class="col-sm-9">
                    {{ Form::textarea('movieScriptTag', e(Input::get('movieScriptTag')), array('class' => 'form-control', 'placeholder' => '動画埋め込みタグを入力', 'rows' => '5')) }}
                    @if($errors->has('movieScriptTag'))
                    <div class="alert alert-danger">
                        {{ $errors->first('movieScriptTag') }}
                    </div>
                    @endif
                </div>
            </div>
            

            <div class="form-actions text-center" style="clear: both; padding-top: 30px;">
                {{ Form::submit('入力した内容の確認', array('class'=>'btn btn-primary submit')) }}
            </div>

        </fieldset>
    {{ Form::hidden('id', Input::get('id')) }}
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop