@extends('layout.admin')


@section('title')
@parent
認証ユーザー作成フォーム
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    ようこそ！ <strong>{{{$authMember->username}}}</strong>さん
</div>


<div class="col-md-3"></div>
</div>
@stop