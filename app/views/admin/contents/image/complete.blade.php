@extends('layout.admin')

@section('title')
@parent
画像コンテンツ 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            @if($executeType === "insert")
            画像コンテンツの新規登録
            @elseif($executeType === "update")
            画像コンテンツの編集
            @elseif($executeType === "delete")
            画像コンテンツの削除
            @endif
        </legend>
        <div class='alert alert-success'>
            
            @if($executeType === "insert")
            画像コンテンツの新規作成が完了しました。
            @elseif($executeType === "update")
            画像コンテンツの編集が完了しました。
            @elseif($executeType === "delete")
            画像コンテンツの削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/contents/image/form" class="list-group-item">画像コンテンツ 新規作成</a>
            <a href="/admin/contents/image/list" class="list-group-item">画像コンテンツ 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop