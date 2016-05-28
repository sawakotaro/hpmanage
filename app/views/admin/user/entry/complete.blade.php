@extends('layout.admin')

@section('title')
@parent
会員{{ ($id ? "編集" : "新規登録") }} 完了画面
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    <fieldset>
        <legend>
            @if($executeType === "insert")
            会員の新規登録
            @elseif($executeType === "update")
            会員の編集
            @elseif($executeType === "delete")
            会員の削除
            @endif
        </legend>
        <div class='alert alert-success'>
            
            @if($executeType === "insert")
            会員の新規作成が完了しました。
            @elseif($executeType === "update")
            会員の編集が完了しました。
            @elseif($executeType === "delete")
            会員の削除が完了しました。
            @endif
        </div>
        
        <div class="list-group">
            @if($executeType === "update")
            {{ HTML::link('/admin/user/entry/form/' . $id, '会員 編集', ['class' => 'list-group-item'])}}
            @else
            {{ HTML::link('/admin/user/entry/form/', '会員 新規登録', ['class' => 'list-group-item'])}}
            @endif
        </div>
    </fieldset>
</div>


<div class="col-md-3"></div>
</div>
@stop