@extends('layout.admin')

@section('title')
@parent
登録カテゴリ 一覧
@stop

@section('content')

{{ HTML::script('/js/admin/menu/category/list.js') }}

<div class="row">
    <div class='col-md-12'>
        <legend>登録カテゴリ 一覧</legend>
        @if($status !== false)
        @if($status === "remove")
        <div class="alert alert-success">
            ※ カテゴリを削除しました。
        </div>
        @endif
        @endif
        <div class="col-md-12 categories text-center">
            
        </div>
        
        
        <div class="col-md-12 space-top-20">
            <div class="col-md-2"></div>
            <div class="col-md-8 category-view text-center">

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
@stop