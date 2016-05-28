@extends('layout.admin')

@section('title')
@parent
運営会社 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            @if($executeType === "insert")
            運営会社の新規登録
            @elseif($executeType === "update")
            運営会社の編集
            @elseif($executeType === "delete")
            運営会社の削除
            @endif
        </legend>
        <div class='alert alert-success'>
            
            @if($executeType === "insert")
            運営会社の新規作成が完了しました。
            @elseif($executeType === "update")
            運営会社の編集が完了しました。
            @elseif($executeType === "delete")
            運営会社の削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            <a href="/admin/setting/company/form" class="list-group-item">運営会社 新規作成</a>
            <a href="/admin/setting/company/list" class="list-group-item">運営会社 一覧</a>
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop