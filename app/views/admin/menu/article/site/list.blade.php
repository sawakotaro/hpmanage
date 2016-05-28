@extends('layout.admin')


@section('title')
@parent
記事管理 取得済み記事一覧
@stop

@section('content')

<script type="text/javascript">
$(function() {
    $(".cb-enable,.cb-disable") .click(function() {
        if($(this).hasClass("selected") === true) {
            var suspended = $(this).attr("suspended");
            var siteId = $(this) .closest("tr").find(".primaryId", this).text();
            var df = $.Deferred();
            $.ajax({
                url     :   "/admin/api/menu/article/site/suspended",
                type    :   "post",
                dataType:   "json",
                data    :   {rssSuspended : suspended, articleSiteId : siteId},
                cache   :   false,
                success :   df.resolve,
                error   :   df.reject
            });
            df.promise().done(function(json) {
                if(json.result === true) {
                    var message = json.rssSuspended === 0 ? "RSSを稼動状態に変更しました。" : "RSSを停止状態にしました。";
                    bootbox.alert("<div class='alert alert-success space-top-20'>"+ message +"</div>");
                } else {
                    bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、RSSの状態を変更できませんでした。</div>");
                }
            }) .fail(function(json) {
                bootbox.alert("<div class='alert alert-danger space-top-20'>通信エラーが発生したため、RSSの状態を変更できませんでした。</div>");
            });
        }
    });
});
</script>

<div class="row">
    <div class="col-md-12">
        <legend>登録済み記事サイト一覧</legend>
        
        @if(count($articleSites))
        {{ Form::open(array("url" => "/admin/menu/article/site/sort", "class" => "form-horizontal")) }}
        <fieldset class="space-bottom-10 space-top-10">
            @if($errors->has('changeId'))
            <div class="alert alert-danger" style="width: 400px;">
                {{ $errors->first('changeId') }}
            </div>
            @elseif($changeStatus === true)
            <div class="alert alert-success" style="width: 400px;">
                表示順の変更をおこないました。
            </div>
            @endif
            {{ Form::select("changeId", $dropdownSelect, Input::get("changeId", null), array("class" => "form-control", "style" => "width: auto; display: inline;")) }}
            の記事サイトを
            &emsp;
            {{ Form::select("targetId", $dropdownSelect, Input::get("targetId", null), array("class" => "form-control", "style" => "width: auto; display: inline;")) }}
            
            &emsp;
            {{ Form::select("option", array("before" => "の前に移動", "after" => "の後に移動", "change" => "と位置を交換"), Input::get("option", null), array("class" => "form-control", "style" => "width: auto; display: inline;")) }}
            &emsp;
            {{ Form::submit("実行", array("class" => "btn btn-primary")) }}
        </fieldset>
        {{ Form::token() }}
        {{ Form::close() }}
        @endif
        
        <fieldset class="sort">
            
        </fieldset>
        
        
        <table class="table table-bordered table-striped">
        @if(count($articleSites))
        <tr>
            <th class="active text-center">ID</th>
            <th class="active text-center">記事サイト名</th>
            <th class="active text-center" style="width: 80px;">タイプ</th>
            <th class="active text-center">サイト URL</th>
            <th class="active text-center">RSS URL</th>
            <th class="active text-center">登録日時</th>
            <th class="active text-center" style="width: 120px;">RSS稼動状況</th>
            <th class="active text-center" style="width: 120px;">アクション</th>
        </tr>
        @foreach($articleSites as $site)
        <tr>
            <td class="text-center primaryId">{{$site->id}}</td>
            <td>{{{$site->name}}}</td>
            <td>{{$site->type === "blog" ? "ブログ" : "アンテナ"}}</td>
            <td>{{link_to($site->site_url, $site->site_url, array('target' => '_blank'))}}</td>
            <td>{{link_to($site->rss_url, $site->rss_url, array('target' => '_blank'))}}</td>
            <td class="text-center">{{{substr($site->created_at, 0, -3)}}}</td>
            <td>
                <p class="field switch">
                    <label for="radio1" suspended="0" class="cb-enable {{$site->rss_suspended == 0 ? 'selected' : ''}}"><span>稼動</span></label>
                    <label for="radio2" suspended="1" class="cb-disable {{$site->rss_suspended != 0 ? 'selected' : ''}}"><span>停止</span></label>
                </p>
            </td>
            <td class="text-center">
               {{link_to('/admin/menu/article/site/form/' . $site->id, '編集', array("class" => "btn btn-info btn-sm"))}}
               {{link_to('/admin/menu/article/site/remove/' . $site->id, '削除', array("class" => "btn btn-danger btn-sm"))}}
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td class="text-center" colspan="8">
                <div class="alert alert-warning">
                    現在、記事サイト情報が１件もありません。<br />
                    {{link_to('/admin/menu/article/site/form', '記事サイト情報を追加')}}してください
                </div>
            </td>
        </tr>
        @endif
        </table>
    </div>
</div>
@stop