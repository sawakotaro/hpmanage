@extends('layout.admin')

@section('title')
@parent
認証ユーザー操作 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            @if($executeType === "insert")
            認証ユーザーの新規登録
            @elseif($executeType === "update")
            認証ユーザーの編集
            @elseif($executeType === "delete")
            認証ユーザーの削除
            @endif
        </legend>
        <div class='alert alert-success'>
            
            @if($executeType === "insert")
            認証ユーザーの新規作成が完了しました。
            @elseif($executeType === "update")
            認証ユーザーの編集が完了しました。
            @elseif($executeType === "delete")
            認証ユーザーの削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/auth/form" class="list-group-item">認証ユーザー 新規作成</a>
            <a href="/admin/auth/list" class="list-group-item">認証ユーザー 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop