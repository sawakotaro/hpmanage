@extends('layout.admin')

@section('title')
@parent
認証ユーザー 一覧
@stop

@section('content')

<script type="text/javascript">
$(function() {
    $(".cb-enable,.cb-disable") .click(function() {
        if($(this).hasClass("selected") === true) {
            var suspended = $(this).attr("suspended");
            var memberId = $(this) .closest("tr").find("td:first-child", this).text();
            var df = $.Deferred();
            $.ajax({
                url     :   "/admin/api/auth/suspended",
                type    :   "post",
                dataType:   "json",
                data    :   {suspended : suspended, memberId : memberId},
                cache   :   false,
                success :   df.resolve,
                error   :   df.reject
            });
            df.promise().done(function(json) {
                if(json.result === true) {
                    var message = json.suspended === 0 ? "認証ユーザーの状態を有効しました。" : "認証ユーザーの状態を無効しました。";
                    bootbox.alert("<div class='alert alert-success space-top-20'>"+ message +"</div>");
                } else {
                    bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、認証ユーザーの状態を変更できませんでした。</div>");
                }
            }) .fail(function(json) {
                bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、認証ユーザーの状態を変更できませんでした。</div>");
            });
        }
    });
});
</script>

<div class="row">
    <div class='col-md-12'>
        <legend>認証ユーザー 一覧</legend>
        <table class="table table-striped">
            <tr>
                <th class="text-center">ユーザーID</th>
                <th class="text-center">ユーザー名</th>
                <th class="text-center">Eメールアドレス</th>
                <th class="text-center">アカウント作成日時</th>
                <th class="text-center">アカウント更新日時</th>
                <th class="text-center">状態</th>
                <th class="text-center">操作</th>
            </tr>
            
            @foreach ($authMembers as $member)
            <tr>
                <td class="text-center">{{$member->id}}</td>
                <td class="text-center">{{{$member->username}}}</td>
                <td class="text-center">{{{$member->email}}}</td>
                <td class="text-center">{{substr($member->created_at, 0, -3)}}</td>
                <td class="text-center">{{substr($member->updated_at, 0, -3)}}</td>
                <td class="text-center">
                    <p class="field switch">
                        <label for="radio1" suspended="0" class="cb-enable {{$member->suspended == 0 ? 'selected' : ''}}"><span>有効</span></label>
                        <label for="radio2" suspended="1" class="cb-disable {{$member->suspended != 0 ? 'selected' : ''}}"><span>無効</span></label>
                    </p>
                </td>
                <td class="text-center">
                    {{link_to('/admin/auth/form/' . $member->id, "編集")}}
                    &emsp;
                    {{link_to('/admin/auth/delete/' . $member->id, "削除")}}
                </td>
            </tr>
            @endforeach
            
        </table>
    </div>

</div>
@stop