@extends('layout.admin')

@section('title')
@parent
カテゴリ設定 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            カテゴリ設定の
            @if($executeType === "insert")
            新規登録
            @elseif($executeType === "update")
            編集
            @elseif($executeType === "delete")
            削除
            @endif
        </legend>
        <div class='alert alert-success'>
            カテゴリ設定の
            @if($executeType === "insert")
            新規作成が完了しました。
            @elseif($executeType === "update")
            編集が完了しました。
            @elseif($executeType === "delete")
            削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/menu/category/form" class="list-group-item">カテゴリ設定 新規作成</a>
            <a href="/admin/menu/category/list" class="list-group-item">カテゴリ設定 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop