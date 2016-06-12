@extends('layout.admin')

@section('title')
@parent
会員検索結果 一覧
@stop

@section('content')
<style type="text/css">
    table th {
        text-align: center;
    }
    td.gender, td.id, td.registered_status, td.action {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="row">
<div class="col-md-1"></div>


<div class='col-md-10'>
    <legend>会員検索結果 一覧</legend>
    <table class="table table-bordered table-striped">
        <tr>
            <th>会員ID</th>
            <th>氏名</th>
            <th>性別</th>
            <th>E-Mail</th>
            <th>登録ステータス</th>
            <th>最終ログイン日時</th>
            <th>アクション</th>
            
        </tr>
        
        @if(count($search_result))
        @foreach($search_result['user_list'] as $user)
        <tr>
            <td class="id">{{$user['id']}}</td>
            <td class="name {{$user['gender'] === 1 ? 'male' : ($user['gender'] === 2 ? 'female' : 'unknown')}}">
                <div><small>{{{$user['last_kana'] . " " . $user['first_kana']}}}</small></div>
                <div>{{{$user['last_name'] . " " . $user['first_name']}}}</div>
            </td>
            <td class="gender">
                @if($user['gender'] === 1)
                <span class="male">男性</span>
                @elseif($user['gender'] === 2)
                <span class="female">女性</span>
                @else
                不明
                @endif
            </td>
            <td class="email">{{{$user['email']}}}</td>
            <td class="registered_status">
                @if($user['registered_status'] === "formal")
                <div class="formal">本登録</div>
                @elseif($user['registered_status'] === "interim")
                <div class="interim">仮登録</div>
                @else
                <div class="withdraw">退会</div>
                @endif
            </th>
            <td class="last_logged_in_at">{{$user['last_logged_in_at']}}</td>
            <td class="action"></td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="7"><div class="alert alert-warning">※ 検索結果に該当する会員データがありません。</td>
        </tr>
        @endif
    
    </table>
</div>


<div class="col-md-1"></div>
</div>
@stop