@extends('layout.admin')


@section('title')
@parent
サイト設定 {{ (Input::get('id') ? "編集" : "新規登録") }}フォーム
@stop

@section('content')

{{ HTML::style('http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css') }}
{{ HTML::script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js') }}
{{ HTML::script('/js/progress.js') }}

<script type="text/javascript">
$(function() {
    $("#upload") .proggresUpload({ filepath : "#filePath", defaultImage : "/images/no-image.gif"});
})
</script>

<div class="row">
    <div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/setting/site/confirm','class' => 'form-horizontal')) }}
        <fieldset>
            <legend>サイト設定の{{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
            <div class="alert alert-warning"><span class="important">※</span>は必須項目</div>
            <div class="form-group">
                {{ Form::label('site_name', 'サイト名', array("class" => "control-label")) }}<span class="important"> ※</span>
                {{ Form::text('site_name', e(Input::get('site_name')), array('class' => 'form-control', 'placeholder' => 'サイト名を入力')) }}
                @if($errors->has('site_name'))
                <div class="alert alert-danger">
                    {{ $errors->first('site_name') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('domain', 'サイトドメイン', array('class' => 'control-label')) }}<span class="important"> ※</span>
                {{ Form::text('domain', e(Input::get('domain')), array('class' => 'form-control', 'placeholder' => 'http://は含めずに入力')) }}
                @if($errors->has('domain'))
                <div class="alert alert-danger">
                    {{ $errors->first('domain') }}
                </div>
                @endif
            </div>
            
            
            
            <div class="form-group">
                {{Form::label('company_id', '運営会社', array('class' => 'control-label'))}}
                {{Form::select("company_id", $companies, Input::get('company_id', null), array('class' => 'form-control'))}}
                @if($errors->has('company_id'))
                <div class="alert alert-danger">
                    {{ $errors->first('company_id') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('title', 'タイトル (SEOで使用されます)', array("class" => "control-label")) }}
                {{ Form::text('title', e(Input::get('title')), array('class' => 'form-control', 'placeholder' => 'サイトタイトルを入力')) }}
                @if($errors->has('title'))
                <div class="alert alert-danger">
                    {{ $errors->first('title') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('keyword', 'キーワード (SEOで使用されます)', array("class" => "control-label")) }}
                {{ Form::text('keyword', e(Input::get('keyword')), array('class' => 'form-control', 'placeholder' => 'カンマ区切りで3つ程度')) }}
                @if($errors->has('keyword'))
                <div class="alert alert-danger">
                    {{ $errors->first('keyword') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('description', 'ディスクリプション (SEOで使用されます)', array("class" => "control-label")) }}
                {{ Form::textarea('description', e(Input::get('description')), array('class' => 'form-control', 'placeholder' => '125文字程度で入力')) }}
                @if($errors->has('description'))
                <div class="alert alert-danger">
                    {{ $errors->first('description') }}
                </div>
                @endif
            </div>
            
            
            <div class="form-group">
                {{ Form::label('logo', 'ロゴ画像', array("class" => "control-label")) }}
                {{ Form::file('logo', array("id" => "upload")) }}
                <div id='loading' class="text-center space-top-10"></div>
                <div id="uploaded" class="text-center">
                
                {{ $filePath = Input::get("filePath"); }}
                @if(!empty($filePath))
                    <img src="{{ Input::get("filePath") }}" style="width: 240px;" />
                @elseif(!is_null($logo))
                <img src="{{ FileUtil::showFile($logo['key']) }}" style="width: 240px;" />
                <script type="text/javascript">$(function() { $("#deleteArea") .show(); })</script>
                @else
                    <img src="/images/no-image.gif" style="width: 240px;" />
                @endif
                </div>
                <div id="progress"></div>
                
                <div class="text-center space-top-10 space-bottom-10" id="deleteArea"><input type="button" class="btn btn-warning deleteLogo" value="ロゴの削除" /> </div>

                
            </div>
            
            <div class="form-actions" style="text-align:center;">
                {{ Form::submit('入力した内容の確認',array('class'=>'btn btn-primary')) }}
            </div>
        </fieldset>
    {{ Form::hidden('filePath', '', array("id" => 'filePath')) }}
    {{ Form::hidden('remove', 'false') }}
    {{ Form::hidden('tmpDir', sha1(Auth::user()->id)) }}
    {{ Form::hidden('APC_UPLOAD_PROGRESS', md5(Auth::user()->id), array("id" => "progress_key")) }}
    {{ Form::hidden('id', Input::get('id')) }}
    @if(!is_null($logo))
    {{ Form::hidden('file_id', $logo['id']) }}
    @endif
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop