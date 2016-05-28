@extends('layout.admin')

@section('title')
@parent
サイト設定 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            @if($executeType === "insert")
            サイト設定の新規登録
            @elseif($executeType === "update")
            サイト設定の編集
            @elseif($executeType === "delete")
            サイト設定の削除
            @endif
        </legend>
        <div class='alert alert-success'>
            
            @if($executeType === "insert")
            サイト設定の新規作成が完了しました。
            @elseif($executeType === "update")
            サイト設定の編集が完了しました。
            @elseif($executeType === "delete")
            サイト設定の削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/setting/site/form" class="list-group-item">サイト設定 新規作成</a>
            <a href="/admin/setting/site/list" class="list-group-item">サイト設定 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop