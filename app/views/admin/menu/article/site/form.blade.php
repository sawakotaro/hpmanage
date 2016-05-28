@extends('layout.admin')


@section('title')
@parent
記事管理 取得済み記事一覧
@stop

@section('content')

<script type="text/javascript">
$(function() {
    $("#upload") .proggresUpload({ filepath : "#filePath", defaultImage : "/images/no-image.gif"});
});
</script>

{{ HTML::style('http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css') }}
{{ HTML::script('http://code.jquery.com/ui/1.10.3/jquery-ui.min.js') }}
{{ HTML::script('/js/progress.js') }}

<div class="row">
    <div class="col-md-3"></div>
    
    <div class="col-md-6">
        {{ Form::open(array('url' => '/admin/menu/article/site/confirm/' . $executeType,'class' => 'form-horizontal')) }}
        <fieldset>
        <legend>記事サイト {{ (Input::get('id') ? "編集" : "新規登録") }}</legend>
        
        <div class="alert alert-warning"><span class="important">※</span>は必須項目</div>
        <div class="form-group">
            {{ Form::label('site_name', '記事サイト名', array("class" => "control-label")) }}<span class="important"> ※</span>
            {{ Form::text('site_name', e(Input::get('site_name')), array('class' => 'form-control', 'placeholder' => '記事サイト名を入力')) }}
            @if($errors->has('site_name'))
            <div class="alert alert-danger">
                {{ $errors->first('site_name') }}
            </div>
            @endif
        </div>
        
        <div class="form-group">
            {{ Form::label('type', '記事タイプ', array("class" => "control-label")) }}<span class="important"> ※</span>
            <div>
                <label>{{ Form::radio('blog_type', 'blog', (Input::get('blog_type') === "blog") ? true : false) }} ブログサイト</label>
                &emsp;
                <label>{{ Form::radio('blog_type', 'antenna', (Input::get('blog_type') === "antenna") ? true : false) }} アンテナサイト</label>
            </div>
        </div>
        
        
        <div class="form-group">
            {{ Form::label('site_url', 'サイトURL', array("class" => "control-label"))}}<span class="important"> ※</span>
            {{ Form::text('site_url', e(Input::get('site_url')), array('class' => 'form-control', 'placeholder' => 'サイトURLを入力 (http://も入力)')) }}
            @if($errors->has('site_url'))
            <div class="alert alert-danger">
                {{ $errors->first('site_url') }}
            </div>
            @endif
        </div>
                
        
        <div class="form-group">
            {{ Form::label('rss_url', 'RSS取得URL', array("class" => "control-label"))}}
            {{ Form::text('rss_url', e(Input::get('rss_url')), array('class' => 'form-control', 'placeholder' => 'RSS取得用URLを入力 (http://も入力)')) }}
            @if($errors->has('rss_url'))
            <div class="alert alert-danger">
                {{ $errors->first('rss_url') }}
            </div>
            @endif
        </div>
        
        
        <div class="form-group">
            {{ Form::label('entry_tag', 'RSS取得用 エントリータグ', array("class" => "control-label"))}}
            {{ Form::text('entry_tag', e(Input::get('entry_tag')), array('class' => 'form-control', 'placeholder' => 'RSSを取得するエントリータグ名を入力')) }}
            @if($errors->has('entry_tag'))
            <div class="alert alert-danger">
                {{ $errors->first('entry_tag') }}
            </div>
            @endif
        </div>
        
                
        <div class="form-group">
            {{ Form::label('title_tag', 'RSS取得用 タイトルタグ', array("class" => "control-label"))}}
            {{ Form::text('title_tag', e(Input::get('title_tag')), array('class' => 'form-control', 'placeholder' => 'RSSを取得するタイトルタグ名を入力')) }}
            @if($errors->has('title_tag'))
            <div class="alert alert-danger">
                {{ $errors->first('title_tag') }}
            </div>
            @endif
        </div>
        
                
        <div class="form-group">
            {{ Form::label('link_tag', 'RSS取得用 リンクタグ', array("class" => "control-label"))}}
            {{ Form::text('link_tag', e(Input::get('link_tag')), array('class' => 'form-control', 'placeholder' => 'RSSを取得するリンクタグ名を入力')) }}
            @if($errors->has('link_tag'))
            <div class="alert alert-danger">
                {{ $errors->first('link_tag') }}
            </div>
            @endif
        </div>
        
                
        <div class="form-group">
            {{ Form::label('description_tag', 'RSS取得用 ディスクリプションタグ', array("class" => "control-label"))}}
            {{ Form::text('description_tag', e(Input::get('description_tag')), array('class' => 'form-control', 'placeholder' => 'RSSを取得するディスクリプションタグ名を入力')) }}
            @if($errors->has('description_tag'))
            <div class="alert alert-danger">
                {{ $errors->first('description_tag') }}
            </div>
            @endif
        </div>
        
        
        <div class="form-group">
            {{ Form::label('rss_suspended', 'RSS記事取得 稼動フラグ', array("class" => "control-label")) }}
            <div>
                <label>{{ Form::radio('rss_suspended', 0, intval(Input::get('rss_suspended')) === 0 ? true : false) }} 稼動</label>
                &emsp;
                <label>{{ Form::radio('rss_suspended', 1, intval(Input::get('rss_suspended')) === 1 ? true : false) }} 停止</label>
            </div>
        </div>
        
        
        <div class="form-group">
            {{ Form::label('image', '記事サイト イメージ画像', array("class" => "control-label")) }}
            {{ Form::file('image', array("id" => "upload")) }}
            <div id='loading' class="text-center space-top-10"></div>
            <div id="uploaded" class="text-center">

            {{ $filePath = Input::get("filePath"); }}
            @if(!empty($filePath))
                <img src="{{ Input::get("filePath") }}" style="width: 240px;" />
            @elseif(!is_null($image))
            <img src="{{ FileUtil::showFile($image['key']) }}" style="width: 240px;" />
            <script type="text/javascript">$(function() { $("#deleteArea") .show(); })</script>
            @else
                <img src="/images/no-image.gif" style="width: 240px;" />
            @endif
            </div>
            <div id="progress"></div>

            <div class="text-center space-top-10 space-bottom-10" id="deleteArea">
                <input type="button" class="btn btn-warning deleteLogo" value="記事サイト イメージ画像の削除" />
            </div>
        </div>
        
        
        <div class="text-center">
            {{ Form::submit('入力した内容の確認',array('class'=>'btn btn-primary')) }}
        </div>
        
        
        </fieldset>
        {{ Form::hidden('filePath', '', array("id" => 'filePath')) }}
        {{ Form::hidden('remove', 'false') }}
        {{ Form::hidden('tmpDir', sha1(Auth::user()->id)) }}
        {{ Form::hidden('APC_UPLOAD_PROGRESS', md5(Auth::user()->id), array("id" => "progress_key")) }}
        {{ Form::hidden('id', Input::get('id')) }}
        @if(!is_null($image))
        {{ Form::hidden('file_id', $image['id']) }}
        @endif
        {{ Form::token() }}
        {{ Form::close() }}
    </div>
    
    <div class="col-md-3"></div>
</div>
@stop