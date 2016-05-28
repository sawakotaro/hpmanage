@extends('layout.admin')

@section('title')
@parent
記事サイトの{{ ($executeType === "remove" ? "削除" : ($executeType === "update") ? "編集" : "新規登録") }}フォーム 確認
@stop

@section('content')

<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/menu/article/site/register/' . $executeType,'class' => 'form-horizontal')) }}
        <fieldset>
            
            <legend>記事サイトの{{ ($executeType === "remove") ? "削除 削除サイトのご確認" : (($executeType === "update") ? "編集 入力内容のご確認" : "新規登録 入力内容のご確認") }}</legend>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('site_name', '記事サイト名', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{Input::get('site_name')}}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('blog_type', '記事タイプ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{ (Input::get('blog_type') === "blog") ? "まとめブログ" : "アンテナサイト" }}}</div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('site_url', '記事サイト URL', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{ link_to(Input::get('site_url'), Input::get('site_url'), array("target" => "_blank")) }}</div>
            </div>
            
            @if(Input::get('rss_url'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('rss_url', 'RSS取得URL', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{ link_to(Input::get('rss_url'), Input::get('rss_url'), array("target" => "_blank")) }}</div>
            </div>
            @endif
            
            
            @if(Input::get('entry_tag'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('entry_tag', 'RSS取得用 エントリータグ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{ Input::get('entry_tag') }}}</div>
            </div>
            @endif
            
            
            @if(Input::get('title_tag'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('title_tag', 'RSS取得用 タイトルタグ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{ Input::get('title_tag') }}}</div>
            </div>
            @endif
            
            
            @if(Input::get('link_tag'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('link_tag', 'RSS取得用 リンクタグ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{ Input::get('link_tag') }}}</div>
            </div>
            @endif
            
            
            @if(Input::get('description_tag'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('description_tag', 'RSS取得用 ディスクリプションタグ', array("class" => "control-label")) }}</div>
                <div class="panel-body">{{{ Input::get('description_tag') }}}</div>
            </div>
            @endif
            
            
            @if(Input::get('filePath'))
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', '記事サイト イメージ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center"><img src='{{{Input::get('filePath')}}}' style="width: 260px;" /></div>
            </div>
            @elseif(Input::get('remove') === 'true' && Input::get('file_id', false) !== false)
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', '記事サイト イメージ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center">
                    <div class='alert alert-warning'>記事サイト イメージ画像は削除されます</div>
                </div>
            </div>
            @elseif(!is_null($image) && count($image) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">{{ Form::label('logo', '記事サイト イメージ画像', array('class' => 'control-label')) }}</div>
                <div class="panel-body text-center"><img src="{{ FileUtil::showFile($image['key']) }}" style="width: 240px;" /></div>
            </div>
            @endif
            
            
           {{ (intval(Input::get('rss_suspended')) === 0) ? "<div class='alert alert-success'>RSS取得 稼動中</div>" : "<div class='alert alert-danger'>RSS取得 停止中</div>"}}
            
            
            <div class="form-actions" style="text-align:center;">
                <input type="submit" name="execute" value="{{ ($executeType === "remove") ? "上記の記事サイトを削除" : (($executeType === "update") ? "この内容で編集" : "この内容で登録") }}" class="btn btn-primary" />
                &emsp;
                <input type="submit" name="cancel" value="キャンセル" class="btn btn-default" />
                @if($executeType === "remove")
                {{ Form::hidden("removeId", Input::get("id")); }}
                @endif
            </div>
        </fieldset>
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop