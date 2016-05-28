@extends('layout.admin')

@section('title')
@parent
記事サイト 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            記事サイトの
            @if($executeType === "add")
            新規登録
            @elseif($executeType === "update")
            編集
            @elseif($executeType === "remove")
            削除
            @endif
        </legend>
        <div class='alert alert-success'>
            記事サイトの
            @if($executeType === "add")
            新規作成が完了しました。
            @elseif($executeType === "update")
            編集が完了しました。
            @elseif($executeType === "remove")
            削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/menu/article/site/form" class="list-group-item">記事サイト 新規作成</a>
            <a href="/admin/menu/article/site/list" class="list-group-item">記事サイト 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop