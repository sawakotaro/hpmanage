@extends('layout.admin')

@section('title')
@parent
ファイルが見つかりませんでした - 404 -
@stop

@section('content')
<div class="row">
<div class="col-md-2"></div>


<div class='col-md-8'>
    <fieldset>
        <legend>お探しの情報が見つかりません。</legend>
        <div class='alert alert-warning'>
            URLをもう一度確認してください。<br />
            探しているページが見つからない場合、URLの記入漏れ・不正な記号などが入力されてないかご確認ください。
        </div>
    </fieldset>
</div>


<div class="col-md-2"></div>
</div>
@stop