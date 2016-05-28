@extends('layout.admin')

@section('title')
@parent
認証ユーザーの削除
@stop

@section('content')
<div class="row">
<div class="col-md-3"></div>


<div class='col-md-6'>
    {{ Form::open(array('url' => '/admin/auth/remove')) }}
    <fieldset>
        <legend>認証ユーザーの削除</legend>
        <div class='alert alert-warning'>
            下記のユーザーを削除しますか？
        </div>
        
        <table class="table table-bordered">

            <tr>
                <th class="text-right active" style="width: 200px;">ID</th>
                <td>{{{$id}}}</td>
            </tr>

            <tr>
                <th class="text-right active">ユーザー名</th>
                <td>{{{$username}}}</td>
            </tr>

            <tr>
                <th class="text-right active">Eメールアドレス</th>
                <td>{{{$email}}}</td>
            </tr>
        </table>
        
        <div class="text-center">
            <input type="submit" name="execute" value="削除" class="btn btn-primary" />
            &emsp;
            <input type="submit" name="cancel" value="キャンセル" class="btn btn-default" />
        </div>
        
    </fieldset>
    {{ Form::hidden('id', e($id)) }}
    {{ Form::token() }}
    {{ Form::close() }}
</div>


<div class="col-md-3"></div>
</div>
@stop