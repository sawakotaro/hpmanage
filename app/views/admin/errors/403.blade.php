@extends('layout.admin')

@section('title')
@parent
許可されていないページ - 403 -
@stop

@section('content')
<div class="row">
<div class="col-md-2"></div>


<div class='col-md-8'>
    <fieldset>
        <legend>許可されていないページ</legend>
        <div class='alert alert-warning'>
            このページを閲覧する権限がありません。<br />
            URLが正しいかどうか確認してください。
        </div>
    </fieldset>
</div>


<div class="col-md-2"></div>
</div>
@stop